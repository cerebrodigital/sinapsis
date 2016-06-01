<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    //
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function post()
    {
        return $this->belongsTo('Post', 'post_id');
    }
}
