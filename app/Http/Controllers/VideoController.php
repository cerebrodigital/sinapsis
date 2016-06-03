<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    private $path = "";
    private $stream = "";
    private $buffer = 102400;
    private $start  = -1;
    private $end    = -1;
    private $size   = 0;
 
    function __construct() 
    {
        //$this->path = $filePath;
    }
    
    public function listVideos()
    {
        $vids = \App\models\Video::paginate(15);
        $active_menu = "videos";
        //dd($vid);
        return view('backend.pages.video_list')->with(compact('vids', 'active_menu'));
    }

    public function jsonImport(Request $request)
    {
        json_encode($request->get('jsontext'));

    }

    public function categoryPage($category) 
    {
        $catID = \App\models\Category::where('slug', trim($category))->first();
        if(count($catID) > 0) {
            $categoria = \App\models\Category::with('posts')->where('id', $catID->id)->paginate(15);
            //dd($categoria);
            return \View::make('frontend.video.categories', compact('categoria'))->render();
        }
        else {
            $categoria = \App\models\Video::with('categories')->paginate(15);
            return \View::make('frontend.video.todas', compact('categoria'))->render();
        }
        //dd($catID->id);
        
        

        
    }

    public function createView()
    {
        //dd($vid);
        $categoriesList = \App\models\Category::with('children')->where('parent_id', '0')->get();
        $active_menu = "videos";
        return view('backend.pages.video_create')->with(compact('active_menu', 'categoriesList'));
    }


    public function postCreateNew(Request $request)
    {
        //dd($vid);
        $video = \App\models\Video::create($request->all());
        if($video)
        {
            $active_menu = "videos";
            return view('backend.pages.video_list')->with('success', 'Video creado satisfactoriamente')->with(compact('active_menu'));
        } 
        else 
        {
            return \Redirect::back()->with('error', 'No se pudo crear');
        }
        
    }

    public function videoUpdate(Request $request)
    {
        //dd($request->all());
        $video = \App\models\Video::find($request->get('id'));
        //dd($video);
        $video->categories()->sync($request->get('categories'));

        if($video->fill($request->all()))
        {
            $video->save();
            return \Redirect::back()->with('success', 'El video fue actualizado correctamente.');
        } 
        else 
        {
            return \Redirect::back()->with('error', 'Sucedio un error en la actualizacion');
        }

    }

    function newEnter(Request $request)
    {
        //dd($request->get('tags'));
        $rules = array(
            'title' => 'required', 
            'description' => 'required', 
            'tags' => 'required', 
            'categories' => 'required', 
            'upload_file' => 'required|mimes:png,jpg,jpeg',
            //'upload_file'  => 'image|mimes:png,jpg,jpeg'
        );
        //dd(\Input::all());

        
        $validator = \Validator::make(\Input::all(), $rules); 

        if ($validator->passes()) {
            $data = array(
                'title'    => \Input::get("title"),
                'description'   => \Input::get("description"),
                'user_id'    => \Input::get("user_id"),
                'comment_id' => \Input::get("comment_id"),
                'likes' => \Input::get("likes"),
                'shares' => \Input::get("shares"),
                'views' => \Input::get("views"),
                'tags'    => $request->get('tags'),
                'media_url'    => \Input::get("media_url"),
                'created_at'   => date("Y-m-d H:i:s"),                
            );

            // Si se esta agregando un archivo JSON, se podrá importar los comentarios.
            

            $categories = \Input::get('categories');
            $categories_count = count($categories);
            $video = \App\models\Video::create($data);
            //dd($post);
            // Checar cada una de las categorias que esta marcada.
            for($i = 0; $i < $categories_count; $i++) {
                $video_categories = \App\models\VideoCategory::create(array('video_id' => $video->id, 'category_id' => $categories[$i]));
            }
            if($request->hasFile('upload_file')) {
                $file = $request->file('upload_file');
                $extension = strtolower($file->getClientOriginalExtension()); // getting image extension
                $fileName = $video->id .'-featured.'.$extension; // renameing image

                $imageUP = \Input::file('upload_file');
                //Manipular la imagen para que mida 800 de ancho y automaticamente resize de alto
                $image = \Image::make($imageUP->getRealPath())->resize('500',null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path() . '/'. $fileName);
                //Guardar en la bucket de amazon aws
                \Storage::disk('s3')->put('videos/featured/'. $fileName, $image->__toString());
                
                $bucket = \Config::get('filesystems.disks.s3.bucket');
                $s3 = \Storage::disk('s3');
                $finalPath = $s3->getDriver()->getAdapter()->getClient()->getObjectUrl($bucket, 'videos/featured/'. $fileName);
                //Actualizar el post con la ruta donde se guardó el archivo
                $videoFinal = \App\models\Video::find($video->id);
                $videoFinal->featured_image = 'http://dn934mu97ziz5.cloudfront.net/videos/featured/'.$fileName;
                $videoFinal->save();
                // Borrando el archivo temporal para liberar espacio
                \File::delete(storage_path() . '/'. $fileName);
            }

                        //verificar que tipo de request de archivo es
            //ver lo del upload del video a amazon s3

            return \Redirect::route('videos.post.list')->with('success', 'La publicación se creó satisfactoriamente, su id es: ' . $video->id);
            //$ID = DB::table("posts")->insert($data);
            //$ID = DB::table("posts")->insert($data);      
            //return \Redirect::to('blog/read/'.Input::get('alias'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
        } else {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
            //->withErrors($validator)->withInput();
        }   
    
    }

    public function editView($id)
    {
        $vid = \App\models\Video::where('id', '=', $id)->with('categories')->first();
        //dd($vid);
        $active_menu = "videos";
        $categoriesList = \App\models\Category::with('children')->where('parent_id', '0')->get();
        //dd($vid);
        return view('backend.pages.video_edit')->with(compact('vid', 'categoriesList', 'active_menu'));
    }


    public function deleteHard($id)
    {
        $vid = \App\models\Video::find($id);
        if( $vid->destroy() ) 
        {
            return \Redirect::back()->with('success', 'El post fue borrado satisfactoriamente.');
        } else 
        {
            return \Redirect::back()->with('error', 'El post no pudo ser borrado.');
        }
    }

        public function deleteSoft($id)
    {
        $vid = \App\models\Video::find($id);
        $vid->status = 'trash';
        if( $vid->save() ) 
        {
            return \Redirect::back()->with('success', 'El post fue borrado satisfactoriamente marcado como basura y no borrado.');
        } else 
        {
            return \Redirect::back()->with('error', 'El post no pudo ser marcado como basura.');
        }
    }

    public function displayOne($id)
    {
        $vids = \App\models\Video::all();
        $vid = \App\models\Video::with('comments')->where('id', '=', $id)->first();
        $vid1 = \App\models\Video::find($id);
        $comments = \App\models\VideoComment::where('video_id', '=', $vid1->id)->simplePaginate(25);

        //dd($vid1);
        return view('frontend.video')->with(compact('vid', 'vids', 'comments'));
    }

    public function displayTodos()
    {
        $vids = \App\models\Video::first();
        //$vid = \App\models\Video::first();
        //dd($vids);
        return \View::make('frontend.video.home',compact('vids'));
    }
    
    public function displayTag($tag)
    {
        $vids = \App\models\Video::where('tags', 'LIKE', $tag.',%')->orWhere('tags', 'LIKE', '%,'.$tag.',%')->orWhere('tags', 'LIKE', '%,'.$tag)->orWhere('tags', '=', $tag)->orderBy('created_at', 'desc')->paginate(15);
        //$vid = \App\models\Video::first();
        //dd($vids);
        return \View::make('frontend.video.list',compact('vids'));
    }

    public function createVideoComment(Request $request, $id)
    {
        $video = \App\models\Video::find($id);
        $comment = new \App\models\VideoComment;
        $comment->name = $request->get('name');
        $comment->message = $request->get('message');
        $comment->video_id = $video->id;
        if($request->get('type') == 'facebook') {
            $comment->fb_id = $request->get('fb_id');
        }
        if($request->has('user_id')) {
            $comment->user_id = $request->get('user_id');
        }
        $video->comments()->save($comment);
        return "Se guardo el comentario";
    }
    /**
     * Open stream
     */
    private function open()
    {
        if (!($this->stream = fopen($this->path, 'rb'))) {
            die('Could not open stream for reading');
        }
         
    }




     
    /**
     * Set proper header to serve the video content
     */
    private function setHeader()
    {
        ob_get_clean();
        header("Content-Type: video/mp4");
        header("Cache-Control: max-age=2592000, public");
        header("Expires: ".gmdate('D, d M Y H:i:s', time()+2592000) . ' GMT');
        header("Last-Modified: ".gmdate('D, d M Y H:i:s', @filemtime($this->path)) . ' GMT' );
        $this->start = 0;
        $this->size  = filesize($this->path);
        $this->end   = $this->size - 1;
        header("Accept-Ranges: 0-".$this->end);
         
        if (isset($_SERVER['HTTP_RANGE'])) {
  
            $c_start = $this->start;
            $c_end = $this->end;
 
            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
            }
            if ($range == '-') {
                $c_start = $this->size - substr($range, 1);
            }else{
                $range = explode('-', $range);
                $c_start = $range[0];
                 
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
            }
            $c_end = ($c_end > $this->end) ? $this->end : $c_end;
            if ($c_start > $c_end || $c_start > $this->size - 1 || $c_end >= $this->size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
            }
            $this->start = $c_start;
            $this->end = $c_end;
            $length = $this->end - $this->start + 1;
            fseek($this->stream, $this->start);
            header('HTTP/1.1 206 Partial Content');
            header("Content-Length: ".$length);
            header("Content-Range: bytes $this->start-$this->end/".$this->size);
        }
        else
        {
            header("Content-Length: ".$this->size);
        }  
         
    }
    
    /**
     * close curretly opened stream
     */
    private function end()
    {
        fclose($this->stream);
        exit;
    }
     
    /**
     * perform the streaming of calculated range
     */
    private function stream()
    {
        $i = $this->start;
        set_time_limit(0);
        while(!feof($this->stream) && $i <= $this->end) {
            $bytesToRead = $this->buffer;
            if(($i+$bytesToRead) > $this->end) {
                $bytesToRead = $this->end - $i + 1;
            }
            $data = fread($this->stream, $bytesToRead);
            echo $data;
            flush();
            $i += $bytesToRead;
        }
    }
     
    /**
     * Start streaming video content
     */
    function start()
    {
        $this->open();
        $this->setHeader();
        $this->stream();
        $this->end();
    }
}
