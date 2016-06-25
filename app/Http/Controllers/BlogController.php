<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Embed\Embed;
use Cache;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Image;
use DomDocument;
use Illuminate\Filesystem\Filesystem;

class BlogController extends Controller
{
    protected $table = 'posts';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $categoriesList = \App\models\Category::with('children')->where('parent_id', '0')->get();
        $active_menu ="blogs";
        return view('backend.pages.post_blog', compact('categoriesList', 'active_menu'));

    }


    public function categoryPage($category) 
    {
        $catID = \App\models\Category::where('slug', trim($category))->first();
        if(count($catID) > 0) {
            //$categoria = \App\models\Category::with('posts')->where('id', $catID->id)->paginate(15);
            $categoria = \App\models\Category::find($catID->id)->posts()->where('status', '=', 'publico')->paginate(20); 
            //dd($categoria);
            return \View::make('frontend.categories', compact('categoria', 'category'));
        }
        else {
            abort(404);
        }
        //dd($catID->id);   
    }




    public function createPost()
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

    function postComment()
    {

        $rules = array(
            'comment' => 'required' 
        );
        $validator = Validator::make(Input::all(), $rules); 
        if ($validator->passes()) {
            $data = array(
                'comment'   => Input::get("comment"),
                'post_id'    => Input::get("blogID"),
                'created_at'   => date("Y-m-d H:i:s"),
                'user_id'   => Session::get('uid')
                
            );
            $ID = DB::table("post_comments")->insert($data);      
            return Redirect::to('blog/read/'.Input::get('alias'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
        } else {
            return Redirect::to('blog/read/'.Input::get('alias'))->with('message', SiteHelpers::alert('error',Lang::get('core.note_error')))
            ->withErrors($validator)->withInput();
        }   
    
    }

    function newEnter(Request $request)
    {
        
        //dd($request->get('type'));
        $rules = array(
            'slug' => 'required', 
            'title' => 'required', 
            'body' => 'required', 
            'categories' => 'required', 
            'status' => 'required',
            'tags' => 'required',
            'type' => 'required',
            'featured_media' => 'required'
            //'upload_file'  => 'image|mimes:png,jpg,jpeg'
        );
        
        $validator = \Validator::make(\Input::all(), $rules); 
        
        if ($validator->passes()) {
            $data = array(
                'slug'   => \Input::get("slug"),
                'title'    => \Input::get("title"),
                'is_featured'    => \Input::get("is_featured"),
                'body'    => \Input::get("body"),
                'user_id'    => \Input::get("user_id"),
                'tags'    => $request->get('tags'),
                'type'    => $request->get('image'),
                'status'    => \Input::get("status"),
                'featured_media'    => $request->get("featured_media"),
                'created_at'   => date("Y-m-d H:i:s"),                
            );
            $categories = \Input::get('categories');
            $categories_count = count($categories);
            $post = \App\models\Post::create($data);
            //dd($post);
            // Checar cada una de las categorias que esta marcada.
            for($i = 0; $i < $categories_count; $i++) {
                $post_categories = \App\models\PostCategory::create(array('post_id' => $post->id, 'category_id' => $categories[$i]));
            }
            // SUBIR LAS FOTOS SI EL BODY LAS CONTIENE
            $dom = new DomDocument();
            $body = \Input::get("body");
            $dom->loadHtml( mb_convert_encoding($body, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');
            // Vamos de imagen en imagen para subirla y cambiar el atributo con URL de Amazon Cloudfront
            foreach($images as $img){
                $src = $img->getAttribute('src');
                
                // if the img source is 'data-url'
                if(preg_match('/data:image/', $src)){
                    
                    // get the mimetype
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];
                    // Generating a random filename
                    $filename = uniqid();
                     // getting image extension
                    $fileName = $filename .'.'.$mimetype; // renameing image
                    //Manipular la imagen para que mida 800 de ancho y automaticamente resize de alto
                    $image = Image::make($src)
                      /* ->resize(300, 200) */
                      ->encode($mimetype, 100)  // encode file to the specified mimetype
                      ->save(storage_path() . '/posting-'. $fileName);
                    //Guardar en la bucket de amazon aws
                    \Storage::disk('s3')->put('blog/uploads/posts/'. $fileName, $image->__toString());
                    $bucket = \Config::get('filesystems.disks.s3.bucket');
                    $s3 = \Storage::disk('s3');
                    $finalPath = $s3->getDriver()->getAdapter()->getClient()->getObjectUrl($bucket, 'blog/uploads/posts/'. $fileName);
                    //Actualizar el post con la ruta donde se guardó el archivo
                    $newFile = 'http://dn934mu97ziz5.cloudfront.net/blog/uploads/posts/'.$fileName;
                    \File::delete(storage_path() . '/posting-'. $fileName);
                    
                    $new_src = asset($newFile);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);
                } // <!--endif
            } // <!--endforeach
            $post = \App\models\Post::find($post->id);
            $post->body = $dom->saveHTML();
            $post->save();




                        //verificar que tipo de request de archivo es
            $reqType = $request->input('type');
            //si es imagen, esta se subira al amazon s3
            if($reqType == 'video') {

                if($request->input('featured_media')) {
                    $info = Embed::create(\Input::get("featured_media"));
                    $updatePost = \App\models\Post::find($post->id);
                    $updatePost->featured_image = $info->image;
                    $updatePost->save();
                }
            }
            if($reqType == 'image') {

                $file = $request->file('upload_file');
                $extension = strtolower($file->getClientOriginalExtension()); // getting image extension
                $fileName = \Input::get("slug") .'.'.$extension; // renameing image

                $imageUP = \Input::file('upload_file');
                //Manipular la imagen para que mida 800 de ancho y automaticamente resize de alto
                $image = \Image::make($imageUP->getRealPath())->resize('800',null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path() . '/'. $fileName);
                //Guardar en la bucket de amazon aws
                \Storage::disk('s3')->put('blog/uploads/'. $fileName, $image->__toString());
                
                $bucket = \Config::get('filesystems.disks.s3.bucket');
                $s3 = \Storage::disk('s3');
                $finalPath = $s3->getDriver()->getAdapter()->getClient()->getObjectUrl($bucket, 'blog/uploads/'. $fileName);
                //Actualizar el post con la ruta donde se guardó el archivo
                $postFinal = \App\models\Post::find($post->id);
                $postFinal->featured_image = 'http://dn934mu97ziz5.cloudfront.net/blog/uploads/'.$fileName;
                $postFinal->featured_media = $finalPath;
                $postFinal->save();
                // Borrando el archivo temporal para liberar espacio
                \File::delete(storage_path() . '/'. $fileName);

              
              //\Input::file('image')->move($destinationPath, $fileName); // mover un archivo a otra parte
              // sending back with message
              \Session::flash('success', 'Upload successfully'); 
            }

            //dd($post);
            return \Redirect::route('blog.post.list')->with('success', 'La publicación se creó satisfactoriamente, su id es: ' . $post->id);
            //$ID = DB::table("posts")->insert($data);
            //$ID = DB::table("posts")->insert($data);      
            //return \Redirect::to('blog/read/'.Input::get('alias'))->with('message', SiteHelpers::alert('success',Lang::get('core.note_success')));
        } else {
            return \Redirect::back()->withInput(\Input::all())->withErrors($validator->errors());
            //->withErrors($validator)->withInput();
        }   
    
    }
    // Funcion para cachear
    public function cachePost($slug) 
    {
        $post = \App\models\Post::where('slug', $slug)->with('user')->first();
        if($post->type == 'video')
        {
            $info = Embed::create($post->featured_media);
            $post->featured_media = $info->code;
            $post->featured = $info->image;
            $info->width = 650;
            return \View::make('frontend.post', compact('post'))->render();
        }
        return \View::make('frontend.post', compact('post'))->render();
    }

    public function viewPost($slug)
    {
        if(\Cache::has('post-'.$slug)) { //Se checa si no hay ya algo cacheado
            $post = Cache::get('post-'. $slug); // Si si, entonces cargarlo y retornalo
            return $post; 
        }
        Cache::store('redis')->put('post-'.$slug, $this->cachePost($slug), 60);  //Si no se encuentra entonces guardalo
        $post = Cache::get('post-'. $slug);
        return $post;      
    }



    public function likePost($id) 
    {
        if(\Auth::check())
        {
            $article = \App\models\Post::find($id);
            $article->like(\Auth::user()->id);
            return \Redirect::back()->with('success', 'Has añadido esta nota como tu favorita');
        } else {
            return \Redirect::to('/login');
        }
        
    }


    public function postEdit($id)
    {
        $post = \App\models\Post::where('id', $id)->with('user')->get();
        $categoriesList = \App\models\Category::with('children')->where('parent_id', '0')->get();
        $active_menu ="blogs";

        return \View::make('backend.pages.post_edit', compact('post', 'categoriesList', 'active_menu'));

    }
    
    public function postDelete(Request $request)
    {
        //dd($request->all());
        $post = \App\models\Post::find($request->id);
        $post->status = 'trash';
        if($post->save())
        {
            return \Redirect::back()->with('success', 'El post:' . $request->id . ' fue marcado como basura.');
        } 
        else 
        {
            return \Redirect::back()->with('error', 'No se pudo eliminar el id:' . $request->id);
        }

    }
    public function postDeletePermanent(Request $request)
    {
        //dd($request->all());
        $post = \App\models\Post::find($request->id);
        if(\Auth::user()->role == "admin") 
        {
            if($post->delete())
            {
                return \Redirect::back()->with('success', 'El post:' . $request->id . ' fue marcado como basura.');
            } 
            else 
            {
                return \Redirect::back()->with('error', 'No se pudo eliminar el id:' . $request->id);
            }
        }
    }

    public function postUpdate(Request $request)
    {
        //dd($request->all());
        $post = \App\models\Post::find($request->get('id'));



        if(!\Gate::denies('admin-access')) 
        {
            $post->categories()->sync($request->get('categories'));

            if($post->fill($request->all()))
            {
                $post->save();
                return \Redirect::back()->with('success', 'El post fue actualizado correctamente.');
            } 
            else 
            {
                return \Redirect::back()->with('error', 'Sucedio un error en la actualizacion');
            }
        } 
        if(!\Gate::denies('post-author', $post->user_id)) 
        {
            $post->categories()->sync($request->get('categories'));

            if($post->fill($request->all()))
            {
                $post->save();
                return \Redirect::back()->with('success', 'El post fue actualizado correctamente.');
            } 
            else 
            {
                return \Redirect::back()->with('error', 'Sucedio un error en la actualizacion');
            }
        } else {
            return "Este usuario no puede editar";
        }

    }



    public function tagPage($tag) 
    {
    
        $posts = \App\models\Post::where('status', '=', 'publicado')->with('user')->where('tags', 'LIKE', $tag.',%')->orWhere('tags', 'LIKE', '%,'.$tag.',%')->orWhere('tags', 'LIKE', '%,'.$tag)->orWhere('tags', '=', $tag)->orderBy('created_at', 'desc')->paginate(7);
/*        $data = array(
            'media' => $media,
            'tag' => $tag,
            'categories' => Category::all(),
            'pages' => Page::all(),
            'settings' => Setting::first(),
            );*/
        
        $videos = \App\models\Video::where('tags', 'LIKE', $tag.',%')->orWhere('tags', 'LIKE', '%,'.$tag.',%')->orWhere('tags', 'LIKE', '%,'.$tag)->orWhere('tags', '=', $tag)->orderBy('created_at', 'desc')->paginate(7);
        //dd($videos);
        return \View::make('frontend.tags', compact('posts', 'tag', 'videos'))->render();
    }


    


    public function helloTest(Filesystem $filesystem)
    {
        $file = $filesystem->get(public_path() .'/hello.txt');
        \Storage::disk('s3')->put('file.txt', 'Contents aqui asi para el file');
        return $file;
    }
}
