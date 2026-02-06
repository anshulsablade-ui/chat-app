<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $myId = Auth::id();
        $participants = ConversationParticipant::where('user_id', $myId)
            ->with([
                'conversation.users' => function ($q) use ($myId) {
                    $q->select('users.id', 'users.name', 'users.email', 'users.image', 'users.is_online', 'users.last_seen')
                        ->where('users.id', '!=', $myId);
                }
            ])
            ->get();

        return view('layouts.app', compact('participants'));
    }

    public function chat($id)
    {
        $myId = Auth::id();

        $conversation = Conversation::where('id', $id)
            ->whereHas('participants', function ($q) use ($myId) {
                $q->where('user_id', $myId);
            })
            ->with([
                'users' => function ($q) use ($myId) {
                    $q->select('users.id', 'users.name', 'users.email', 'users.image')->where('users.id', '!=', $myId);
                }
            ])
            ->first();
        $totalUsers = $conversation->users()->count();

        $messages = Message::with('sender:id,name,image')
            ->where('conversation_id', $id)
            ->orderBy('id')
            ->get();

        return response()->json([
            'messages' => $messages,
            'conversationId' => $conversation->id,
            'conversation' => $conversation,
            'totalUsers' => $totalUsers
        ]);
    }

    public function send(Request $request)
    {
        // dd($request->all());
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => Auth::user()->id,
            'message' => $request->message,
        ]);

        $message = Message::with(['sender:id,name,image'])->where('id', $message->id)->first();
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

    public function getUsers(Request $request)
    {

        $authId = Auth::id();

        $users = User::where('id', '!=', $authId)
            ->withExists([
                'conversations as has_conversation' => function ($q) use ($authId) {

                    $q->whereIn('conversations.id', function ($sub) use ($authId) {
                        $sub->select('conversation_id')
                            ->from('conversation_participants')
                            ->where('user_id', $authId);
                    });

                }
            ])
            ->get();

        return response()->json($users);
    }

}
