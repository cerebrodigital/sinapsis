<?php

namespace App\models;
use Conner\Likeable\LikeableTrait;
use Illuminate\Database\Eloquent\Model;

class ForumMessage extends Model
{
    use LikeableTrait;
    protected $table      = 'forum_messages';


    public function topic()
    {
      return $this->belongsTo('App\models\ForumTopic', 'parent_topic');
    }

    public function author()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function scopeWhereTopicIn($query, Array $topics)
    {
      if (count($topics) == 0)
      {
        return $query;
      }
      return $query->whereIn('parent_topic', $topics);
    }

}
