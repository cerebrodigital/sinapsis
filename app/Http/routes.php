<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



//Load any url:
//Get content info

Route::get('/facebook/login', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
{
    // Send an array of permissions to request
    $login_url = $fb->getLoginUrl(['email']);
    //dd($login_url);

    // Obviously you'd do this in blade :)
    return \Redirect::to($login_url);
    //echo '<a href="' . $login_url . '">Login with Facebook</a>';
});
Route::get('/facebook/callback', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
{
    // Obtain an access token.
    try {
        $token = $fb->getAccessTokenFromRedirect();
        
        //dd($token);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.


    if (! $token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = $fb->getOAuth2Client();

        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }

    $fb->setDefaultAccessToken($token);

    // Save for later
    Session::put('fb_user_access_token', (string) $token);


    $videos = \App\models\Video::where('processed', 0)->get();
    echo '<br><b style="color:green;">Obteniendo todos los videos para procesarlos en total #' . count($videos) . ' videos<b>';
    if( count($videos) > 0 ) {
        foreach($videos as $video) {
            $res = [];
            // Get basic info on the user from Facebook.
            if($video->comment_id != 0) {
                echo '<br>El video: ' . $video->id . ' tiene un id de facebook para extraer correos.';
                try {
                    $response = $fb->get('193647527313377_' . $video->comment_id . '/comments?pretty=0&limit=500');
                } catch (Facebook\Exceptions\FacebookSDKException $e) {
                    dd($e->getMessage());
                }
                $facebook_user = $response->getGraphEdge();
                
                foreach ($facebook_user as $node) {
                    $res[] = $node->asArray();
                } 
                echo "<br>Verificando si hay segunda pagina después de 500 resultados.";
                if($nextP = $fb->next($facebook_user)) {
                    echo "<br>Si existe segundos resultados total: " . count($res);
                    foreach ($nextP as $node) {
                        $res[] = $node->asArray();
                    }
                    echo "<br>Verificando si hay segunda pagina después de 1000 resultados.";
                    if($nextP2 = $fb->next($nextP)) {
                        "<br>Si existe terceros resultados total: " . count($res);
                        foreach ($nextP2 as $node) {
                            $res[] = $node->asArray();
                        }
                        echo "<br>Verificando si hay segunda pagina después de 1500 resultados.";
                        if($nextP3 = $fb->next($nextP2)) {
                            "<br>Si existe terceros resultados total: ". count($res);
                            foreach ($nextP3 as $node) {
                                $res[] = $node->asArray();
                            }
                        }

                    }
                }
                //por cada una de los comentarios que tenemos en nuestro array $res
                foreach($res as $r)
                { 
                    //dd($r['created_time']->format('Y-m-d H:i:s'));
                    $comment = array(
                        'fb_id'    => $r['from']['id'],
                        'message'   => $r['message'],
                        'name'    => $r['from']['name'],
                        'type'    => 'facebook',
                        'video_id'    => $video->id,
                        'created_at'   => $r['created_time']->format('Y-m-d H:i:s'),
                        'updated_at'   => $r['created_time']->format('Y-m-d H:i:s'),                 
                    );
                    $comment_post = \App\models\VideoComment::create($comment);
                    unset($comment);
                    unset($timestamp);
                    unset($comment_post);
                }
                $videocomments = \App\models\VideoComment::where('video_id', $video->id)->get();
                echo '<br>Procesamos y agregamos #' . count($videocomments) . ' comentarios en el id del video:' . $video->id;
                $videoUpdate = \App\models\Video::find($video->id);
                $videoUpdate->processed = true;
                $videoUpdate->save();
            } else {
                echo '<br>El video con id: ' . $video->id . ' no tiene ninguna variable comment_id para extraer comentarios de facebook, siguiendo al siguiente video.';
            } // Cierra el if/else que checa si tiene comment_id en cero o si tiene   
        }
    } else {
        echo '<br><b style="color:blue">no se encontro ningún video marcado como no-procesado para extracción de comentarios<b>';
    }
});

Route::get('/', array('uses' => 'LandingController@index', 'as' => 'landing'));
// Authentication routes...
Route::get('login', array('uses' => 'Auth\AuthController@getLogin', 'as' => 'sinapsis.login'));
Route::post('auth/login', array('uses' => 'Auth\AuthController@postLogin', 'as' => 'sinapsis.login.post'));
Route::get('logout', array('uses' => 'Auth\AuthController@getLogout', 'as' => 'sinapsis.logout'));

Route::get('test', function() {
    $post = \App\models\Post::find(1);
    \Event::fire(new \App\Events\ViewPostHandler($post));

});

Route::get('neuronas', function() {
    return \View::make('frontend.neuronas');
});

//SHOUTS
Route::post('shouts/send', array('uses' => 'ShoutsController@create', 'as' => 'shouts.create'));

//VIDEOS
Route::get('video/{id}', array('uses' => 'VideoController@displayOne', 'as' => 'video.view.one'));
Route::get('videos', array('uses' => 'VideoController@displayTodos', 'as' => 'video.view.todos'));
Route::get('videos/categorias', array('uses' => 'VideoController@listAllCategories', 'as' => 'video.view.categorias'));

Route::post('video/{id}/comentario', array('uses' => 'VideoController@createVideoComment', 'as' => 'video.post.comment'));
Route::post('video/{id}/edit', array('uses' => 'VideoController@videoUpdate', 'as' => 'videos.post.edit'));

Route::get('video/{id}', array('uses' => 'VideoController@displayOne', 'as' => 'video.view.one'));
Route::get('video/tag/{tag}', array('uses' => 'VideoController@displayTag', 'as' => 'video.view.tag'));

Route::get('video/categoria/{category}', array('uses' => 'VideoController@categoryPage', 'as' => 'video.view.category'));

//Route::get('video/file/{filename}', array('uses' => 'VideoController@displayFile', 'as' => 'video.view.file'));

// Prueba tags PLAYING CON CODIGO
Route::get('test/tags', function() {
    $post_tags = \App\models\Post::all(['tags']);
    $final = "";
    foreach($post_tags as $tag)
    {
        $final .= $tag->tags .",";
    }
    $order = explode(',', $final);
    dd(array_count_values($order));
});



// Registration routes...
Route::get('register', array('uses' => 'Auth\AuthController@getRegister', 'as' => 'sinapsis.register.get'));
Route::post('register', array('uses' => 'Auth\AuthController@postRegister', 'as' => 'sinapsis.register.post'));

// Password reset link request routes...
Route::get('password/email', array('uses' => 'Auth\PasswordController@getEmail', 'as' => 'sinapsis.password.reset')); 
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('dashboard/perfil', 'DashboardController@home');
Route::get('perfil/{id}', array('uses' => 'DashboardController@authorProfile', 'as' => 'dashboard.profile'));

Route::get('auth/facebook', array('uses' => 'Auth\AuthController@redirectToProvider', 'as' => 'sinapsis.facebook.register'));
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');




// BLOG ROUTES 
Route::get('{slug}', array('uses' => 'BlogController@viewPost', 'as' => 'blog.view.post')); 
Route::get('tags/{tag}', array('uses' => 'BlogController@tagPage', 'as' => 'blog.view.tag'));
Route::get('categoria/{category}', array('uses' => 'BlogController@categoryPage', 'as' => 'blog.view.category'));
Route::get('hello/world', array('uses' => 'BlogController@hello', 'as' => 'blog.view.hello'));


Route::group(['prefix' => '/agora', 'middleware' => ['auth', 'admin']], function () {
    Route::get('json/migrate', function() {
        $active_menu = "videos";
        return \View::make('backend.pages.json_migrate', compact('active_menu'));

    });
    Route::post('video/json/import', array('uses' => 'VideoController@jsonImport', 'as' => 'video.json.import'));
    // Rutas de Badges KPI
    Route::get('index', 'BadgesController@index');
    Route::get('manage', 'BadgesController@manage');
    Route::get('simulate', 'BadgesController@simulate');
    Route::get('display', 'BadgesController@display');
    // VIDEOS MODULE
    Route::group(['prefix' => '/videos', 'middleware' => ['auth', 'admin']], function () {
        Route::get('lista', array('uses' => 'VideoController@listVideos', 'as' => 'videos.post.list'));
        Route::get('crear', array('uses' => 'VideoController@createView', 'as' => 'videos.view.create'));
        Route::post('crear/video', array('uses' => 'VideoController@newEnter', 'as' => 'videos.post.create'));
        Route::post('update/video/{id}', array('uses' => 'VideoController@videoUpdate', 'as' => 'videos.post.update'));
        Route::get('editar/{id}', array('uses' => 'VideoController@editView', 'as' => 'videos.view.edit'));
        Route::get('post/{id}/delete', array('uses' => 'VideoController@deleteSoft', 'as' => 'videos.delete.soft'));
        Route::post('post/{id}/delete/permanent', array('uses' => 'VideoController@deleteHard', 'as' => 'videos.delete.hard'));
        
    });

    //Rutas de Blog
    Route::get('home', array('uses' => 'BackendController@home', 'as' => 'backend.home')); 
    Route::get('blog/lista', array('uses' => 'BackendController@listPosts', 'as' => 'blog.post.list'));
    Route::get('blog/lista/publicas', array('uses' => 'BackendController@listPostsPublic', 'as' => 'blog.post.public'));
    Route::get('blog/lista/draft', array('uses' => 'BackendController@listPostsDraft', 'as' => 'blog.post.draft'));
    Route::get('blog/lista/basura', array('uses' => 'BackendController@listPostsTrash', 'as' => 'blog.post.trash'));
    Route::get('blog/post/crear', array('uses' => 'BlogController@index', 'as' => 'blog.post.create'));
    Route::post('blog/post/{id}/update', array('uses' => 'BlogController@postUpdate', 'as' => 'blog.post.update'));
    Route::get('blog/post/{id}/delete', array('uses' => 'BlogController@postDelete', 'as' => 'blog.post.delete'));
    Route::get('blog/post/{id}/delete/permanent', array('uses' => 'BlogController@postDeletePermanent', 'as' => 'blog.post.deletePermanent'));
    Route::get('blog/post/edit/{id}', array('uses' => 'BlogController@postEdit', 'as' => 'blog.post.edit'));
    Route::get('perfil', 'BackendController@profile');
    Route::get('blog/posts/publicos', array('uses' => 'BlogController@publicList', 'as' => 'blog.public.list'));
    Route::get('blog/posts/drafts', array('uses' => 'BlogController@draftsList', 'as' => 'blog.draft.list'));

    //Rutas de categorías
    Route::post('categorias/crear', array('uses' => 'CategoriesController@store', 'as' => 'category.new'));
    Route::get('categorias', array('uses' => 'CategoriesController@index', 'as' => 'category.index'));    



    Route::post('blog/create', array('uses' => 'BlogController@newEnter', 'as' => 'blog.create.new'));

});


if (Request::is('api/*'))
{
    require __DIR__.'/api_routes.php';
}