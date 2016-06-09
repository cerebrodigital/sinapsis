<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $fillable = array('title', 'slug', 'parent_id', 'description');
    public $table = 'forum_categories';


    public function parent()
    {
        return $this->belongsTo('App\models\ForumCategory', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\models\ForumCategory', 'parent_id');
    }

    public function topics()
    {
      return $this->hasMany('App\models\ForumTopic', 'parent_category');
    }

    public function scopeWhereTopLevel($query)
    {
      return $query->where('parent_category', '=', NULL);
    }

    public function scopeTopicCount()
    {
        return $this->topics()->count();
    }

    public function getReplyCountAttribute()
    {
      return $this->rememberAttribute('replyCount', function(){
        $replyCount = 0;
        $topicsIds = array();
        $topics    = $this->topics()->get(array('id'));
        foreach ($topics AS $topic) {
          $topicsIds[] = $topic->id;
        }
        if (!empty($topicsIds)) 
        {
          $replyCount = \App\models\ForumMessage::whereIn('parent_topic', $topicsIds)->count();
        }
        return $replyCount;
      });
    }

}
