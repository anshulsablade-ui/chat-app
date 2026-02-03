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
        
        $messages = Message::with(['sender:id,name,image'])->where('conversation_id', 1)->get();
        // dd($messages->toArray(), $users->toArray());  
        return view('layouts.app', compact('users', 'messages'));
    }

    public function chat($id)
    {
        $user = User::find($id);
        $messages = Message::with(['sender:id,name,image'])->where('conversation_id', 1)->get();
        // dd($messages->toArray());
        return view('component.chat', compact('messages', 'user'))->render();
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
