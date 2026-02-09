<?php

namespace App\Notifications;

use App\Models\Conversation;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class NewMessageNotification extends Notification
{
    use Queueable;

    public $message;
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        $conversation = Conversation::where('id', $this->message->conversation_id)->first();
        return [
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->name,
            'sender_image' => $this->message->sender->image,
            'conversation_name' => $conversation->title ?? null,
            'message' => $this->message->message,
        ];
    }

    public function toBroadcast($notifiable)
    {
        $conversation = Conversation::where('id', $this->message->conversation_id)->first();
        $count = DB::table('notifications')
            ->where('notifiable_id', $notifiable->id)
            ->where('notifiable_type', get_class($notifiable))
            ->whereNull('read_at')
            ->where('data->conversation_id', $this->message->conversation_id)
            ->count();
            
        return new BroadcastMessage([
            'conversation_id' => $this->message->conversation_id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->name,
            'sender_image' => $this->message->sender->image,
            'conversation_name' => $conversation->title ?? null,
            'message' => $this->message->message,
            'total_notifications' => $count,
        ]);
    }
}
