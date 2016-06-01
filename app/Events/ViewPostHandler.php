<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Session\Store;
use App\models\Post;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ViewPostHandler extends Event
{
    use SerializesModels;


    public $post;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $post->increment('total_views');

        $post->total_views += 1; 
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
