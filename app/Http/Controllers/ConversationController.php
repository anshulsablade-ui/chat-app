<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ConversationController extends Controller
{
    public function createGroup(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'group_name' => 'required|string|max:255',
            'users' => 'required|array|min:2',
            'users.*' => 'required|exists:users,id',
            'group_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            
        ]);
        if ($validator->fails()) {
            return response()->json([ 'status' => false, 'message' => $validator->errors() ], 422);
        }
        $conversation = Conversation::create([
            'title' => $request->group_name,
            'type' => 'group'
        ]);

        if ($request->hasFile('group_image')) {
            $image = $request->file('group_image');
            $imageName = $request->group_name . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/conversations'), $imageName);
            $conversation->group_image = $imageName;
            $conversation->save();
        }
        ConversationParticipant::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id()
        ]);
        foreach ($request->users as $user) {
            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $user
            ]);
        }

        return response()->json([ 'status' => true, 'message' => 'Group created successfully' ], 200);
    }

    public function createConversation(Request $request)
    {
        $conversation = Conversation::create([
            'type' => 'private'
        ]);
        foreach ($request->users as $user) {
            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $user
            ]);
        }
        return response()->json([ 'status' => true, 'message' => 'Conversation created successfully' ], 200);
    }
}
