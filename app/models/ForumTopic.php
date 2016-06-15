<?php

namespace App\models;
use Conner\Likeable\LikeableTrait;
use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{

    use LikeableTrait;

    protected $table      = 'forum_topics';

    public function category()
    {
      return $this->belongsTo('App\models\ForumCategory', 'parent_category');
    }
    public function author()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function messages()
    {
      return $this->hasMany('App\models\ForumMessage',  'topic_id');
    }
    public function getReplyCountAttribute()
    {
      return $this->messages()->count();
    }
}
