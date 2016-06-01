<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    //
    protected $table = 'post_categories';
    protected $fillable = array('post_id', 'category_id');

    public function posts()
    {
        return $this->hasMany('App\models\Post', 'id', 'post_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\models\Category', 'category_id');
    }


    public static function dropdownList() {
        return array('' => 'Seleccionar Categoria') + PostCategory::orderBy('name', 'asc')->owns()->get()->lists('name', 'id');
    }
}
