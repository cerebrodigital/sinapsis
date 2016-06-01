@extends('frontend.master_post')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">Categoría</h2>
              <ul>
                <li><a href="#home">Artículos</a></li>
                <li>Categoría: , #{{$categoria->count()}} publicaciones encontradas.</li>
              </ul>
            </div>
          </div>
@endsection

@section('main')
  <h2><span>Últimos artículos agregado en la categoría: </span></h2>
  
    
  
  @foreach($categoria as $cat)
    @if($cat->posts->count() > 0)
      <div class="content-padding">
        <br>
        <h3 align="center">Se encontraron {{$cat->posts->count()}} resultados. </h3>
      </div>
      @foreach($cat->posts as $post)
            <div class="content-padding">
              
              <div class="article-promo">
                <div class="article-photo">
                  <span class="article-image-out">
                    <span class="image-comments"><span>21</span></span>
                    <span class="article-image">
                      <span class="nth1 strike-tooltip" title="Leer Artículo">
                        <a href="{{route('blog.view.post',$post->slug)}}"><i class="fa fa-eye"></i></a>
                      </span>
                      <span class="nth2 strike-tooltip" title="Leer después">
                        <a href="#"><i class="fa fa-plus"></i></a>
                      </span>
                      <a href="{{route('blog.view.post',$post->slug)}}"><img src="{{$post->featured_media}}" alt="" title="" /></a>
                    </span>
                  </span>
                </div>
                
                <div class="article-content">
                  <h3><a href="{{route('blog.view.post',$post->slug)}}">{{$post->title}}</a></h3>
                  <div class="article-icons">
                    <a href="{{route('dashboard.profile', $post->user->id)}}" class="user-tooltip"><i class="fa fa-fire"></i>{{$post->user->username}}</a>
                    <a href="{{route('blog.view.post',$post->slug)}}"><i class="fa fa-calendar"></i>{{$post->created_at}}</a>
                  </div>
                  <p>Has no atqui dictas iuvaret, ex suavitate voluptatum incorrupte eos. Nullam luptatum nominati ius voluptatum ea, nam omnium percipit et luptatum nominati ius ea...</p>
                  <a href="{{route('blog.view.post',$post->slug)}}" class="defbutton"><i class="fa fa-reply"></i>Leer Artículo completo</a>
                </div>
              </div>
              
              <div class="clear-float do-the-split"></div>
            </div>
            
      @endforeach

        
    @else
      <div class="content-padding">
        <br>
        <h3 align="center">No se encontraron resultados. </h3>
      </div>
    @endif
    
      
  @endforeach
  

@endsection  

@section('sidebar')
          <aside id="sidebar">
            
            <!-- WIDGET READES SOCIALES -->
            @include('frontend.widgets.social')
            
            <!-- WIDGET EVENTO POR VENIR -->
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=250582038314020";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-page" data-href="https://www.facebook.com/tucerebrodigital" data-width="305" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/tucerebrodigital"><a href="https://www.facebook.com/tucerebrodigital">Cerebro Digital</a></blockquote></div></div>

            
            <!-- WIDGET LOS MAS VISTOS DE LA SEMANA-->
            @include('frontend.widgets.most_viewed')
            <!-- WIDGET DUELO DE LA SEMANA -->
            @include('frontend.widgets.weekly_duel')
            <!-- WIDGET ULTIMAS PUBLICACIONES -->
            @include('frontend.widgets.latest_posts')      
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