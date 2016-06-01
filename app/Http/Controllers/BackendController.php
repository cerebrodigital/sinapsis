<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function home()
    {
        $active_menu = "deck";
        return \View::make('backend.pages.home', compact('active_menu'));
        //return view('backend.pages.home')->with(compact('active_menu'));
    }

    public function profile()
    {
        return view('backend.pages.myprofile');
    }
    

    public function listPosts()
    {
        $posts = \App\models\Post::with('user')->orderBy('created_at', 'DESC')->paginate(20);
        $active_menu = "blogs";
        return \View::make('backend.pages.post_list', compact('posts', 'active_menu'));

    }

    public function listPostsTrash()
    {
        $posts = \App\models\Post::where('status', 'trash')->with('user')->orderBy('created_at', 'DESC')->paginate(20);
        $active_menu = "blogs";
        return \View::make('backend.pages.post_list', compact('posts', 'active_menu'));
    }
    
    public function listPostsPublic()
    {
        $posts = \App\models\Post::where('status', 'publicada')->with('user')->orderBy('created_at', 'DESC')->paginate(20);
        $active_menu = "blogs";
        return \View::make('backend.pages.post_list', compact('posts', 'active_menu'));
    }

    public function listPostsDraft()
    {
        $posts = \App\models\Post::where('status', 'draft')->with('user')->orderBy('created_at', 'DESC')->paginate(20);
        $active_menu = "blogs";
        return \View::make('backend.pages.post_list', compact('posts', 'active_menu'));
    }

}
