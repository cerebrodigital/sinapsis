<?php
namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{

    public function indexCache() 
    {
        $topics = \App\models\ForumTopic::with('messages', 'author', 'category')->orderBy('updated_at', 'DESC')->paginate(7);
        $videos =  \App\models\Video::with('user')->orderBy('created_at', 'desc')->take(10)->get();
        $featured = \App\models\Post::with('user')->where('status', '=', 'publico')->orderBy('created_at', 'desc')->take(8)->get();
        $populares = \App\models\Post::with('user')->where('status', '=', 'publico')->orderBy('total_views', 'desc')->take(6)->get();
        $latest = \App\models\Post::with('user')->where('status', '=', 'publico')->orderBy('created_at', 'desc')->take(4)->get();
        
        //dd($featured);
        return \View::make('welcome', compact('featured', 'latest', 'populares', 'videos', 'topics'))->render();
    }

    public function index(Request $request)
    {
        if(\Cache::has('welcome')) {
            $welcome = Cache::get('welcome'); // Si si, entonces cargarlo y retornalo
            return $welcome; 
        }
        Cache::store('redis')->put('welcome', $this->indexCache(), 60);
        $welcome = Cache::get('welcome');
        return $welcome;  
    }


}