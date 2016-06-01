<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rules = array(
            'title' => 'required', 
            'body' => 'required', 
            'featured_media' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules); 
        if ($validator->passes()) {
            $data = array(
                'title'   => Input::get("title"),
                'body'    => Input::get("body"),
                'created_at'   => date("Y-m-d H:i:s"),
                'user_id'   => Session::get('uid')
                
            );
            $post = DB::table("posts")->insert($data);

            return Redirect::to('blog/read/'.Input::get('alias'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
        } else {
            return Redirect::to('blog/read/'.Input::get('alias'))->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
            ->withErrors($validator)->withInput();
        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'slug' => 'required', 
            'title' => 'required', 
            'body' => 'required', 
            'status' => 'required',
        );
        
        $validator = \Validator::make(\Input::all(), $rules); 

        if ($validator->passes()) {
            $data = array(
                'slug'   => \Input::get("slug"),
                'title'    => \Input::get("title"),
                'body'    => \Input::get("body"),
                'user_id'    => \Input::get("user_id"),
                'status'    => \Input::get("status"),
                'created_at'   => date("Y-m-d H:i:s"),                
            );
            $tags = explode(',', \Input::get('tags'));
            $post = \App\models\Post::create($data);
            foreach($tags as $tagName)
            {
                $slug = strtolower($tagName);
                $slug = preg_replace("/[^a-z0-9_\s-]/", "", $slug);
                $slug = preg_replace("/[\s-]+/", " ", $slug);
                $slug = preg_replace("/[\s_]/", "-", $slug);

                $tag  =  \App\models\Tag::firstOrNew(array('name' => $tagName, 'slug' => $slug));
                $tag->save();

                $relation = \DB::table('post_tags')->insert(
                                ['post_id' => $post->id, 'tag_id' => $tag->id]
                            );
                //$tagpost = TagPost::create(array('post_id' => $post->id, 'tag_id' => $$tag->id));
            }
            dd($post);
            //$ID = DB::table("posts")->insert($data);
            //$ID = DB::table("posts")->insert($data);      
            //return \Redirect::to('blog/read/'.Input::get('alias'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
        } else {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
            //->withErrors($validator)->withInput();
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = \App\models\Post::where('slug', $slug)->with('user')->get();
        
        $post[0]->total_views = $post[0]->total_views + 1;
        $post->update(array('total_views' => $post[0]->total_views ));
        dd($post[0]->total_views);
        return \View::make('frontend.post', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = \App\models\Post::where('id', $id)->with('user')->get();
        return \View::make('backend.pages.post_edit', compact('post'));
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
}
