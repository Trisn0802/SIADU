<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotification implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $title;
    public $message;
    public $url;
    public $id_notifikasi;

    public function __construct($userId, $title, $message, $url, $id_notifikasi = null)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->id_notifikasi = $id_notifikasi;
    }

    public function broadcastOn()
    {
        return ['user-notif.' . $this->userId];
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'id_notifikasi' => $this->id_notifikasi,
        ];
    }
}
