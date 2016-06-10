<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Session\Store;
use App\models\ForumTopic;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ViewForumTopicHandler extends Event
{
    use SerializesModels;


    public $forum_topic;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ForumTopic $forum_topic)
    {
        $forum_topic->increment('views');

        $forum_topic->views += 1; 
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