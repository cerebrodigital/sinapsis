<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * Media Repository
     *
     * @var Meda
     */
    protected $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $media = $this->media->all();

        return View::make('media.index', compact('media'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array(
            'categories' => Category::orderBy('order', 'ASC')->get(),
            'settings' => Setting::first(),
            );

        return View::make('Theme::upload', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if(!Auth::guest() && Auth::user()->active){

            $input = Input::all();
            $validation = Validator::make($input, Media::$rules);

            $valid_media = false;
            if(isset($input['pic_url']) && !empty($input['pic_url'])){
                $valid_media = true;
            } else if(isset($input['img_url']) && $input['img_url'] != ''){
                $valid_media = true;
            } else if(isset($input['vid']) && $input['vid'] != ''){
                $valid_media = true;
            }

            if ($validation->passes() && $valid_media)
            {
                if(isset($input['pic'])){

                    if(isset($input['img_url']) && $input['img_url'] != ''){
                        $input['pic_url'] = ImageHandler::uploadImage($input['img_url'], 'images', Helper::slugify($input['title']), 'url');
                        //unset($input['pic_url_multi']);
                    } else if(isset($input['pic_url'])){
                        $input['pic_url'] = ImageHandler::uploadImage(Input::file('pic_url'), 'images');
                        
                        $input['pic'] = 1;
                    }
                    
                    if(isset($input['pic_url_multi'])){
                        $input['pic_url_multi'] = '';
                        $listDeleteImg = $input['delete_img'];
                        
                        $multi_pics = array_filter( Input::file('pic_url_multi') );
                        if(!empty($multi_pics)){
                            foreach ($multi_pics as $value) {
                                $getName = $value->getClientOriginalName();
                                $getSize = $value->getSize();
                                $getPush = $getSize ."-".$getName;
                                $findImg = strpos($listDeleteImg,$getPush);
                                if($findImg !== false) {
                                    // Found
                                    $listDeleteImg = preg_replace("/$getPush/","",$listDeleteImg,1);
                                } else {
                                    // Not found
                                    $input['pic_url_multi'] .= ImageHandler::uploadImage($value, 'images');
                                }
                                $input['pic_url_multi'] .= ';';
                            }
                        }
                        $input['pic_url_multi'] = trim($input['pic_url_multi'], ";");
                    } else {
                        unset($input['pic_url_multi']);
                    }
                }
                
                unset($input['img_url']);

                if(isset($input['vid'])){

                    unset($input['pic_url_multi']);

                    if(isset($input['vid_url'])){
                        unset($input['vid']);
                        
                        if (strpos($input['vid_url'], 'youtube') > 0 || strpos($input['vid_url'], 'youtu.be') > 0) {
                            $video_id = Youtubehelper::extractUTubeVidId($input['vid_url']);
                            if(isset($video_id[1])){
                                $img_url = 'http://img.youtube.com/vi/'. $video_id . '/0.jpg';
                                $input['pic_url'] = ImageHandler::uploadImage($img_url, 'images', true, Helper::slugify($input['title']), 'url');
                            } else {
                                unset($input['vid_url']);
                            }
                            $input['vid'] = 1;
                        } elseif(strpos($input['vid_url'], 'vimeo') > 0) {
                            $vimeo_id = (int)substr(parse_url($input['vid_url'], PHP_URL_PATH), 1);
                            $link = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vimeo_id.php"));
                            $image = $link[0]['thumbnail_large'];  
                            
                            $input['pic_url'] = ImageHandler::uploadImage($image, 'images', Helper::slugify($input['title']), 'url');
                            $input['vid'] = 1;
                        } elseif(strpos($input['vid_url'], 'vine') > 0){
                            $video_id = explode('/v/', $input['vid_url']);
                            $video_id = str_replace('/embed', '', $video_id[1]);
                            $video_id = str_replace('/', '', $video_id);
                            if(isset($video_id)){
                                ini_set('default_socket_timeout', 120);
                                $vine = file_get_contents("http://vine.co/v/$video_id");
                                preg_match('/property="og:image" content="(.*?)"/', $vine, $matches);

                                $image = ($matches[1]) ? $matches[1] : '';
                                $input['pic_url'] = ImageHandler::uploadImage($image, 'images', Helper::slugify($input['title']), 'url');
                            } else {
                                unset($input['vid_url']);
                            }
                            $input['vid'] = 1;
                        }
                    }
                }

                $this->add_daily_media_points();

                $setting = Setting::first();
                if(!$setting->auto_approve_posts){
                    $input['active'] = 0;
                }

                if(isset($input['nsfw'])){
                    $input['nsfw'] = 1;
                } else {
                    $input['nsfw'] = 0;
                }

                $input['title'] = htmlspecialchars(stripslashes($input['title']));

                $input['slug'] = Helper::slugify($input['title']);

                if(isset($input['description'])){
                    $input['description'] = htmlspecialchars(stripslashes($input['description']));
                }
                
                $slugexist = Media::where('slug', '=', $input['slug'])->first();
                $increment = 1;
                while(isset($slugexist->id)){
                    $input['slug'] = $input['slug'] . '-' . $increment;
                    $slugexist = Media::where('slug', '=', $input['slug'])->first();
                    $increment += 1;
                }

                $new_media = $this->media->create($input);

                return Redirect::to('media' . '/' . $new_media->slug)->with(array('note' => Lang::get('lang.upload_success'), 'note_type' => 'success') );
            }

            return Redirect::to('/upload')->with(array('note' => Lang::get('lang.error_uploading'), 'note_type' => 'error') );

        } else {
            return Redirect::to('/')->with(array('note' => Lang::get('lang.login_to_upload'), 'note_type' => 'error') );
        }
    }

    public function random()
    {
        if(DB::table('media')->count() > 0){
            $random = Media::where('active', '=', 1)->orderBy(DB::raw('RAND()'))->first();
            return Redirect::to('/media/' . $random->slug);
        } else {
            return Redirect::to('/');
        }
    }

    // When user submits media award them 1 point, max 5 per day

    private function add_daily_media_points(){
        $user_id = Auth::user()->id;

        $LastQuestionPoints = Point::where('user_id', '=', $user_id)->where('description', '=', Lang::get('lang.daily_upload'))->orderBy('created_at', 'desc')->take(5)->get();
        
        $total_daily_questions = 0;
        foreach($LastQuestionPoints as $QuestionPoint){
            if( date('Ymd') ==  date('Ymd', strtotime($QuestionPoint->created_at)) ){
                $total_daily_questions += 1;
            }
        }

        if($total_daily_questions < 5){
            $point = new Point;
            $point->user_id = $user_id;
            $point->description = Lang::get('lang.daily_upload');
            $point->points = 1;
            $point->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */

    public function show($slug)
    {
        $media = Media::with('media_likes', 'comments')->where('slug', '=', $slug)->first();

        if(isset($media)){

            $view_increment = $this->handleViewCount($media->id);
            
            $next = Media::where('active', '=', 1)->where('created_at', '>', date("Y-m-d H:i:s", strtotime($media->created_at)) )->first();
            $previous = Media::where('active', '=', 1)->where('created_at', '<', date("Y-m-d H:i:s", strtotime($media->created_at)) )->orderBy('created_at', 'desc')->first();
            $media_next = Media::where('active', '=', 1)->where('created_at', '>=', date("Y-m-d H:i:s", strtotime($media->created_at)) )->take(6)->get();
    
            $next_media_count = $media_next->count();
    
            if($next_media_count < 6){
                $get_prev_results = 6 - $next_media_count;
                $media_prev = Media::where('active', '=', 1)->where('created_at', '<', date("Y-m-d H:i:s", strtotime($media->created_at)) )->orderBy('created_at', 'DESC')->take($get_prev_results)->get();
            } else{
                $media_prev = array();
            }
    
            $data = array(
                'item' => $media,
                'media_next' => $media_next,
                'next' => $next,
                'previous' => $previous,
                'media_prev' => $media_prev,
                'view_increment' => $view_increment,
                'settings' => Setting::first(),
                'categories' => Category::all(),
                'pages' => Page::all(),
                'single' => true,
                );
            return View::make('Theme::media', $data);
        } else {
            return Redirect::to('/');
        }
    }

    public function handleViewCount($id){

        // check if this key already exists in the view_media session
        $blank_array = array();
        if (! array_key_exists($id, Session::get('viewed_media', $blank_array) ) ) {
            
            try{
                // increment view
                $media = Media::find($id);
                $media->views = $media->views + 1;
                $media->save();

                // Add key to the view_media session
                Session::put('viewed_media.'.$id, time());
                return true;

            } catch (Exception $e){
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $media = $this->media->find($id);

        if (is_null($media))
        {
            return Redirect::route('media.index');
        }

        return View::make('media.edit', compact('media'));
    }

    // Add Media Flag

    public function add_flag(){
        $id = Input::get('media_id');
        $media_flag = MediaFlag::where('user_id', '=', Auth::user()->id)->where('media_id', '=', $id)->first();

        if(isset($media_flag->id)){ 
            $media_flag->delete();
        } else {
            $flag = new MediaFlag;
            $flag->user_id = Auth::user()->id;
            $flag->media_id = $id;
            $flag->save();
            echo $flag;
        }
    }


    // Add Media Like

    public function add_like(){
        $id = Input::get('media_id');
        $media_like = MediaLike::where('user_id', '=', Auth::user()->id)->where('media_id', '=', $id)->first();

        if(isset($media_like->id)){ 
            $media_like->delete();
        } else {
            $like = new MediaLike;
            $like->user_id = Auth::user()->id;
            $like->media_id = $id;
            $like->save();
            echo $like;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $media = Media::find($id);
        if(Auth::user()->admin == 1 || Auth::user()->id == $media->user_id){
            
            $settings = Setting::first();

            try{
                $input = Input::all();

                if($settings->media_description){
                    $media->description = htmlspecialchars($input['description']);
                }

                if(Auth::user()->admin == 1){
                    $media->slug = htmlspecialchars($input['slug']);
                }

                if(isset($input['nsfw'])){
                    $input['nsfw'] = 1;
                } else {
                    $input['nsfw'] = 0;
                }

                $media->nsfw = $input['nsfw'];

                $media->title = htmlspecialchars($input['title']);
                $media->category_id = $input['category'];
                $media->link_url = htmlspecialchars($input['source']);
                $media->tags = htmlspecialchars($input['tags']);
                $media->save();
                return Redirect::to($input['redirect'])->with(array('note' => Lang::get('lang.update_success'), 'note_type' => 'success') );
            } catch(Exception $e){
                return Redirect::to($input['redirect'])->with(array('note' => Lang::get('lang.update_error') . ': ' . $e->getMessage(), 'note_type' => 'error') );
            }

        } else {
            return Redirect::to('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        $media = Media::find($id);

        if($media->user_id == Auth::user()->id || Auth::user()->admin == 1){

            $media_flags = MediaFlag::where('media_id', '=', $id)->get();
            foreach($media_flags as $media_flag){
                $media_flag->delete();
            }

            $media_likes = MediaLike::where('media_id', '=', $id)->get();
            foreach($media_likes as $media_like){
                $media_like->delete();
            }

            $comments = Comment::where('media_id', '=', $id)->get();
            foreach($comments as $comment){
                $comment_votes = CommentVote::where('comment_id', '=', $comment->id)->get();
                foreach($comment_votes as $comment_vote){
                    $comment_vote->delete();
                }

                $comment_flags = CommentFlag::where('comment_id', '=', $comment->id)->get();
                foreach($comment_flags as $comment_flag){
                    $comment_flag->delete();
                }

                $comment->delete();
            }

            // if the media type is a gif we need to remove the animation file too.
            if(strpos($media->pic_url, '.gif') > 0){
                if(file_exists(Config::get('site.uploads_dir') . 'images/' . str_replace(".gif", "-animation.gif", $media->pic_url))){
                    unlink(Config::get('site.uploads_dir') . 'images/' . str_replace(".gif", "-animation.gif", $media->pic_url));
                }
            }

            // remove the image
            if(file_exists(Config::get('site.uploads_dir') . 'images/' . $media->pic_url)){
                unlink(Config::get('site.uploads_dir') . 'images/' . $media->pic_url);
            }


            $media->delete();

        }

        return Redirect::to('admin?section=media')->with(array('note' => Lang::get('lang.delete_success'), 'note_type' => 'success') );
    }


    // Sanitize Image URL's

    private function sanitize($string, $force_lowercase = true, $anal = false) {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                       "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                       "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

}
