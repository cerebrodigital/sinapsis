<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Jobs;

abstract class Job
{
    /**
     * Fire an event.
     *
     * @param  mixed $event
     * @return void
     */
    public function fire($event)
    {
        event($event);
    }
}
