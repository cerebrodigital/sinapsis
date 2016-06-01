<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    protected $table = 'video_categories';
    protected $fillable = array('video_id', 'category_id');

    public function videos()
    {
        return $this->hasMany('App\models\Video', 'id', 'video_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\models\Category', 'category_id');
    }


    public static function dropdownList() {
        return array('' => 'Seleccionar Categoria') + VideoCategory::orderBy('name', 'asc')->owns()->get()->lists('name', 'id');
    }
}
