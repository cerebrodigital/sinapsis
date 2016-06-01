<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Shout extends Model
{
    protected $table = 'shouts';
    protected $fillable = array('message', 'parent_id', 'user_id', 'status');

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
