<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', Auth::user()->id)->get();
        return view('layouts.app', compact('users'));
    }

    public function chat($id)
    {
        $user = User::find($id);
        $messages = Message::where('conversation_id', $id)->get();
        return view('component.chat', compact('messages', 'user'))->render();
    }

    public function send(Request $request)
    {
        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => Auth::user()->id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
