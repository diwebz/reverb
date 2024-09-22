<?php

namespace App\Events;

use Log;
use App\Models\Reservations;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReservationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    // public $reservations;
    // public $receivedCount;

    // public function __construct(Reservations $reservations, $receivedCount)
    // {
    //     $this->reservations = $reservations;
    //     $this->receivedCount = $receivedCount;
    // }

    // public function __construct(
    //     public string $reservations
    // )
    // {

    // }

    // public function __construct(
    //     public string $reservations,
    //     public string $receivedCount
    // )
    // {

    // }

    public $reservations;
    public $receivedCount;

    public function __construct($reservations)
    {
        $this->reservations = $reservations;
        // Get the real-time count of reservations with "Received" status
        $this->receivedCount = Reservations::where('res_status', 'Received')->count();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('reservations-channel');
    }

    // public function broadcastAs(): string
    // {
    //     return 'ReservationCreated';
    // }

    // public function broadcastWith(): array
    // {
    //     return [
    //         'reservations' => $this->reservations
    //     ];
    // }

    public function broadcastWith()
    {
        return [
            'reservations' => json_encode($this->reservations),
            'receivedCount' => $this->receivedCount, // Send the updated count
        ];
    }
}
