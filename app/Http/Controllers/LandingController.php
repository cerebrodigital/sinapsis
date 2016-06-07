<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{


    public function index(Request $request)
    {
        $videos =  \App\models\Video::with('user')->orderBy('created_at', 'desc')->take(10)->get();
        $featured = \App\models\Post::with('user')->orderBy('created_at', 'desc')->take(8)->get();
        $populares = \App\models\Post::with('user')->orderBy('total_views', 'desc')->take(6)->get();
        $latest = \App\models\Post::with('user')->orderBy('created_at', 'desc')->take(4)->get();
        //dd($featured);
        return \View::make('welcome', compact('featured', 'latest', 'populares', 'videos'));
    }
}