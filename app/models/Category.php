<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = array('name', 'slug', 'parent_id');
    public $table = 'categories';

    public function posts() 
    {
      return $this->belongsToMany('App\models\Post', 'post_categories');
    }
    public function videos() 
    {
      return $this->belongsToMany('App\models\Video', 'video_categories');
    }
    public function parent()
    {
        return $this->belongsTo('App\models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\models\Category', 'parent_id');
    }

    public function postCategories()
    {
        return $this->hasMany('App\models\PostCategory', 'category_id');
    }

        public function videoCategories()
    {
        return $this->hasMany('App\models\VideoCategory', 'category_id');
    }

    public static function dropdownList()
    {
        $categories =  Category::orderBy('name', 'asc')->lists('name'); 
        $categories->prepend('Selecionar', 'Seleccionar');
        return $categories;
    }

}
