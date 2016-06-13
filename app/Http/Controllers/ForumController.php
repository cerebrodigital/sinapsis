<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use s9e\TextFormatter\Bundles\Forum as TextFormatter;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{


    public function test()
    {
        $text = 'To-do list:
        [list]
          [*] Say hello to the world :)
          [*] Go to http://example.com
          [*] Try to trip the parser with [b]mis[i]nes[/b]ted[u] tags[/i][/u]
          [*] Watch this video: [media]http://www.youtube.com/watch?v=QH2-TGUlwu4[/media]
        [/list]';

        // Parse the original text
        $xml = TextFormatter::parse($text);

        return TextFormatter::render($xml);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTopic(Request $request)
    {
        //dd($request->get('type'));
        $rules = array(
            'title' => 'required', 
            'message' => 'required', 
            'tags' => 'required', 
            'parent_id' => 'required',
            //'upload_file'  => 'image|mimes:png,jpg,jpeg'
        );
        
        $validator = \Validator::make(\Input::all(), $rules); 
        
        if ($validator->passes()) {
            $slug = slugify($request->get('title'));
            //dd($request->all());
            $message = $request->get('message');
            $xml = TextFormatter::parse($message);
            $topic = new \App\models\ForumTopic();
            $topic->title = $request->get('title');
            $topic->parent_category = $request->get('parent_id');
            $topic->tags = $request->get('tags');
            $topic->slug = $slug;
            $topic->message = TextFormatter::render($xml);
            $topic->user_id = \Auth::user()->id;
            $topic->save();
            return redirect()->route('foro.topic.id', $topic->id);
        } else {

            return \Redirect::back()->withInput(\Input::all())->withErrors($validator->errors());
        }


    }

    public function createTopicView()
    {
        $categoriesList = \App\models\ForumCategory::with('children')->where('parent_id', '0')->get();
        //dd($categoriesList);
        return \View::make('frontend.forum.create_topic', compact('categoriesList'));
    }

    public function topic($id)
    {
        $topic = \App\models\ForumTopic::where('id', '=', $id)->with('messages', 'author', 'category')->first();
        //dd($topic);
        if($topic) {
            \Event::fire(new \App\Events\ViewForumTopicHandler($topic));
            return \View::make('frontend.forum.topic', compact('topic'));
        } else {
            abort(404);
        }
        
        
    }

    public function listAllTopics()
    {
        $topics = \App\models\ForumTopic::with('messages', 'author', 'category')->paginate(25);
        //dd($topic);
        return \View::make('frontend.forum.topics_list', compact('topics'));
    }
    public function listTopicByCategory($id)
    {
        $topics = \App\models\ForumTopic::where('parent_category', '=', $id)->with('messages', 'author', 'category')->orderBy('updated_at', 'DESC')->take(30)->get();
        if(count($topics) > 0) {
            $title = $topics[0]->category->title;
            return \View::make('frontend.forum.topics_category', compact('topics', 'title'));
        } else {
            abort(404);
        }
    }

    public function createMessage(Request $request, $id)
    {
        $message = $request->get('message');
        $xml = TextFormatter::parse($message);

        $msg = new \App\models\ForumMessage();
        $msg->topic_id = $id;
        $msg->message = TextFormatter::render($xml);
        $msg->user_id = \Auth::user()->id;
        $msg->save();
        return redirect()->route('foro.topic.id', ['id' => $id]);
    }

}
