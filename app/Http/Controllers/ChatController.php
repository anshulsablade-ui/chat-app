<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $countNotifications = auth()->user()->unreadNotifications->pluck('data.conversation_id')->unique()->count();

        return view('layouts.app', compact('participants', 'countNotifications'));
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

        $conversation = Conversation::find($request->conversation_id);
        $users = $conversation->users()->where('users.id', '!=', auth()->id())->get();
        foreach ($users as $user) {
            $user->notify(new NewMessageNotification($message));
        }

        return response()->json(['message' => $message]);
    }

    public function getUsers(Request $request)
    {

        $authId = Auth::id();

        $users = User::where('id', '!=', $authId)
            ->withExists([
                'conversations as has_conversation' => function ($q) use ($authId) {

                    $q->where('type', 'private')->whereIn('conversations.id', function ($sub) use ($authId) {
                        $sub->select('conversation_id')
                            ->from('conversation_participants')
                            ->where('user_id', $authId);
                    });

                }
            ])
            ->get();
            
        return response()->json($users);
    }

    public function getNotifications(Request $request)
    {
        $userId = auth()->id();

        $grouped = DB::table('notifications')
            ->select(
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.conversation_id')) as conversation_id"),
                DB::raw("MAX(id) as latest_id"),
                DB::raw("COUNT(*) as count")
            )
            ->where('notifiable_id', $userId)
            ->whereNull('read_at')
            ->groupBy('conversation_id')
            ->get();

        $latestIds = $grouped->pluck('latest_id');

        $notifications = DB::table('notifications')
            ->whereIn('id', $latestIds)
            ->get()
            ->map(function ($notification) use ($grouped) {

                $conversationId = json_decode($notification->data)->conversation_id;

                $count = $grouped
                    ->firstWhere('conversation_id', $conversationId)
                    ->count;

                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'notifiable_type' => $notification->notifiable_type,
                    'notifiable_id' => $notification->notifiable_id,
                    'data' => json_decode($notification->data, true),
                    'count' => $count,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at,
                    'updated_at' => $notification->updated_at,
                ];
            });

        return response()->json($notifications);
    }

    public function clearNotifications(Request $request)
    {
        DB::table('notifications')->where('notifiable_id', auth()->id())->delete();
        return redirect()->route('chat.index');
    }
    public function clearNotificationsForConversation(Request $request)
    {
        $conversationId = $request->conversation_id;

        Auth::user()
            ->unreadNotifications
            ->where('data.conversation_id', $conversationId)
            ->each(function ($notification) {
                $notification->delete();

            });
        return response()->json(['success' => true, 'total_notifications' => auth()->user()->unreadNotifications()->count()]);
    }

}
