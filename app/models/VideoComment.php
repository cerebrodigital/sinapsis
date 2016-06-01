<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class VideoComment extends Model
{
    protected $table = 'video_comments';
    protected $fillable = array('name', 'message', 'type', 'video_id', 'fb_id', 'created_at', 'updated_at');

    public function video()
    {
        return $this->belongsTo('App\models\Video', 'id', 'video_id');
    }

}
