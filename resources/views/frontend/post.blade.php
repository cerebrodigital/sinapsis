@extends('frontend.master_post')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">Blog</h2>
              <ul>
                <li><a href="#home">Noticia</a></li>
                <li>Categoria</li>
              </ul>
            </div>
          </div>
@endsection



@section('main')
  
      @section('title'){{$post->title}}@endsection
      @section('description'){!! substr(strip_tags($post->body), 0, 180) !!}...@endsection
      @section('keywords'){{$post->tags}}@endsection
      @section('image'){{$post->featured_media}}@endsection
  <h2><span>{{$post->title}}</span></h2>
  <div class="content-padding">

    <div class="article-full">
      <div class="article-main-photo">
        @if($post->type == "video")
          {!!$post->featured_media!!}
          <!-- EMBED VIDEO from Youtube, vimeo, dailymotion-->
          
        @else
          <img src="{{$post->featured_media}}" width="650" alt="" title="" />
        @endif
      </div>
      <div class="article-icons">
        <a href="{{route('dashboard.profile', $post->user->id)}}" class="user-tooltip"><i class="fa fa-fire"></i>{{$post->user->username}}</a>
        <b>Categorías:</b>
         @foreach($post->categories()->get() as $category)
          {{$category->name}}, 
        @endforeach
        <a href="#"><i class="fa fa-calendar"></i>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->format('d M Y')}}</a>
        <a href="#" class="show-views"><i class="fa fa-eye"></i>{{$post->total_views}} vistas </a>

      </div>
      <br>
      <!-- ESTA ES PARA ORG <div class='shareaholic-canvas' data-app='share_buttons' data-app-id='24569125'></div> -->
      <div style="float:left;"><b style="font-size:15px">COMPARTIR:</b></div> <div align="left" class="addthis_sharing_toolbox"></div>

      <div class="article-content">
        <p>{!!$post->body!!}</p>

        
      </div>
      <div>
      <b>Tags: </b> {{$post->tags}}
      </div>
      <br>
    </div>
    
    <!-- <div class="clear-float do-the-split"></div> -->
    
    <!-- BEGIN .article-footer -->
    <div class="article-footer">
      <div class="about-author">
        
        <h2><span>Acerca del autor</span></h2>

        <div class="inner">
          <a href="{{route('dashboard.profile', $post->user->id)}}" class="avatar avatar-large online user-tooltip">
            <img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($post->user->email))); ?>" alt="" class="author-image setborder" />
          </a>
          <div class="side">
            <a href="{{route('dashboard.profile', $post->user->id)}}" class="comment-user user-tooltip"><b>{{$post->user->username}}</b></a>
            <i>{{$post->user->name}}</i>

            <a href="#"><i class="fa fa-comment"></i>{{count(\App\models\Post::where('user_id',$post->user->id)->get())}} Articles</a>
          </div>
          <div class="clear-float">

            <p>Esta es una descripcion alternativa de este perfil pronto habra perfiles.</p>


          </div>
        </div>

      </div>

      <div class="similar-posts">
        
        <h2><span>Últimos artículos del autor</span></h2>
        
        <div class="home-article right">
          <ul>
          <?php $author_posts = \App\models\Post::byAuthor($post->user_id)->orderBy('created_at', 'DESC')->take(3)->get(); ?>
          @foreach($author_posts as $author_post)
            <li>
              <a href="{{route('blog.view.post', $author_post->slug)}}">
                <span class="image-comments"><span>10</span></span>
                <img src="{{$author_post->featured_media}}" alt="" title="">
                <strong>{{  substr(strip_tags($author_post->title), 0, 20)  }}</strong>
                <span class="a-txt">{{   substr(strip_tags($author_post->body), 0, 30)   }}...</span>
              </a>
            </li>
            @endforeach

          </ul>
          
        </div>

      </div>
    <!-- END .article-footer -->
    </div>

  <!-- END .content-padding -->
  </div>
  <!-- HERE I ATTACH THE INCLUDE -->
  <h2><span>Comentarios</span></h2>
  <div class="content-padding">
    <div class="comment-part">
    @include('comments::display', ['pageId' => $post->slug])
    </div>
  </div>

  <!-- END .content-padding -->

  

@endsection  

@section('sidebar')
          <aside id="sidebar">
            
            <!-- WIDGET READES SOCIALES -->
            @include('frontend.widgets.social')
            
            <!-- WIDGET EVENTO POR VENIR -->
            <!-- WIDGET ULTIMAS PUBLICACIONES -->
            @include('frontend.widgets.latest_posts')

            <!-- WIDGET DUELO DE LA SEMANA -->
            @include('frontend.widgets.weekly_duel')
            
            <!-- WIDGET LOS MAS VISTOS DE LA SEMANA-->
            @include('frontend.widgets.most_viewed')
            
            <!-- WIDGET DONACIONES -->


            
            
            

            
            
            
            <!-- WIDGET INFORMACION DE CONTACTO -->
            

            
          <!-- END #sidebar -->
          </aside>
@endsection   
@section('bottomscripts')
    <link rel="stylesheet" href="/vendor/comments/css/bootstrapless.css">
    <link rel="stylesheet" href="/vendor/comments/css/prism-okaidia.css"> <!-- Optional -->
    <link rel="stylesheet" href="/vendor/comments/css/comments.css">
    <script src="//cdn.jsdelivr.net/vue/1.0.16/vue.min.js"></script>

    <!-- Must be included before the closing </body> tag! -->
    <script src="/vendor/comments/js/utils.js"></script> 
    <script src="/vendor/comments/js/comments.js"></script>
    <script>new Vue({el: '#comments'});</script>
    <script type='text/javascript'>
      var strike_autostart = false;
    </script>
    <style>
      li.comment.fade-transition {
          padding-right: 22px;
      }

      div.comment-content.clearfix {
          margin-left: -100px;
          width: 100%;
      }
    </style>
@endsection     