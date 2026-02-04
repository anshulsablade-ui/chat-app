<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
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

        // 1. Get all conversation IDs where I am a participant
        $conversationIds = ConversationParticipant::where('user_id', $myId)->pluck('conversation_id');

        // 2. Get other users from those same conversations
        $users = User::where('id', '!=', $myId)
            ->whereHas('conversation_participants', function ($q) use ($conversationIds) {
                $q->whereIn('conversation_id', $conversationIds);
            })
            // ->with(['messages' => function ($q) use ($conversationIds) {
            //         $q->where('conversation_id', $conversationIds);
            //     }
            // ])
            ->get();


        // $lastMessage = Message::where('conversation_id', $conversationIds)->latest()->first();

        // $users = Auth::user();
        // dd($users->toArray());
        return view('layouts.app', compact('users'));
    }

    public function chat($id)
    {
        $conversationId = ConversationParticipant::where('user_id', Auth::id())
            ->whereIn(
                'conversation_id',
                ConversationParticipant::where('user_id', $id)->pluck('conversation_id')
            )
            ->value('conversation_id');

        if (!$conversationId) {
            abort(404, 'Conversation not found');
        }

        $user = User::findOrFail($id);

        $user = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'image' => $user->image,
            'last_seen' => $user->is_online ? 'Online' : 'Last seen ' . $user->last_seen?->diffForHumans(),
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];

        $messages = Message::with('sender:id,name,image')
            ->where('conversation_id', $conversationId)
            ->orderBy('id')
            ->get();

        return response()->json(['messages' => $messages, 'conversationId' => $conversationId, 'user' => $user]);
        // return view('component.chat', compact('messages', 'user'))->render();
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
}
