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
                    $q->select('users.id', 'users.name', 'users.image', 'users.is_online', 'users.last_seen')
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
                    $q->select('users.id', 'users.name', 'users.image')->where('users.id', '!=', $myId);
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
            'conversationId' => $messages[0]->conversation_id, 
            'conversation' => $conversation,
            'totalUsers' => $totalUsers
        ]);
    }

    // public function chat($id)
    // {
    //     $conversationId = ConversationParticipant::where('user_id', Auth::id())
    //         ->whereIn(
    //             'conversation_id',
    //             ConversationParticipant::where('user_id', $id)->pluck('conversation_id')
    //         )
    //         ->value('conversation_id');

    //     if (!$conversationId) {
    //         abort(404, 'Conversation not found');
    //     }

    //     $user = User::findOrFail($id);

    //     $user = [
    //         'id' => $user->id,
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'phone' => $user->phone,
    //         'image' => $user->image,
    //         'last_seen' => $user->is_online ? 'Online' : 'Last seen ' . $user->last_seen?->diffForHumans(),
    //         'created_at' => $user->created_at,
    //         'updated_at' => $user->updated_at
    //     ];

    //     $messages = Message::with('sender:id,name,image')
    //         ->where('conversation_id', $conversationId)
    //         ->orderBy('id')
    //         ->get();

    //     return response()->json(['messages' => $messages, 'conversationId' => $conversationId, 'user' => $user]);
    //     // return view('component.chat', compact('messages', 'user'))->render();
    // }


    public function send(Request $request)
    {
        // dd($request->all());
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => Auth::user()->id,
            'message' => $request->message,
            'type' => $request->type ?? 'text'
        ]);

        $message = Message::with(['sender:id,name,image'])->where('id', $message->id)->first();
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

    public function getUsers(Request $request){
        $users = User::all();
        return response()->json($users);
    }

    public function searchUser(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->name . '%')
            ->where('id', '!=', Auth::id())
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'image' => $user->image,
                    'last_seen' => $user->is_online ? 'Online' : $user->last_seen?->diffForHumans(),
                ];
            });
        return response()->json($users);
    }
}
