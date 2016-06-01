<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastCommentWasPosted extends CommentWasPosted implements ShouldBroadcast
{
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['comment.'.$this->comment->page_id];
    }
}
