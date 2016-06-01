<?php

/**
 * This file is part of Ajax Comment System for Laravel™.
 *
 * (c) HazzardWeb <hazzardweb@gmail.com>
 *
 * For the full copyright and license information, please visit:
 * http://codecanyon.net/licenses/standard
 */

namespace Hazzard\Comments\Comments;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    const UP = 'up';
    const DOWN = 'down';
    const REMOVE = 'remove';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'type'];
}
