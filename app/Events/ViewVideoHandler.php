<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Session\Store;
use App\models\Video;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ViewVideoHandler extends Event
{
    use SerializesModels;


    public $video;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $video->increment('views');

        $video->views += 1; 
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    
    public function broadcastOn()
    {
        return [];
    }
}