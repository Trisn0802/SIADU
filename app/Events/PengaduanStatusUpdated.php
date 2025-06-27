<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PengaduanStatusUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $id_pengaduan;
    public $status;

    public function __construct($id_pengaduan, $status)
    {
        $this->id_pengaduan = $id_pengaduan;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new Channel('pengaduan.status');
    }
}
