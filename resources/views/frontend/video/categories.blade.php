@extends('frontend.master_video')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">Videos</h2>
              <ul>
                <li><a href="#home">Categoria</a></li>
                <li>Últimos #{{$categoria->count()}} videos agregados de la categoria {{$category}}</li>
              </ul>
            </div>
          </div>
@endsection



@section('main')
<section >
      @section('title')Videos de {{$category}} @endsection
      @section('description')Sección dedicada a videos de la categoría {{$category}}@endsection
      @section('keywords'){{$category}}@endsection
    
    @if($categoria->count() > 0)
      <section class="content">
        
        <!-- BEGIN .wrapper -->
        <div class="wrapper">
          
          <!-- BEGIN .with-sidebar-layout -->
          <div class="with-sidebar-layout left">


            <div class="content-panel">
              <div class="panel-title">
                <h2>Últimos videos Agregados</h2>
                <div class="right video-set-layout">
                  <a href="#v-set-layout" rel="grid" ><i class="fa fa-th"></i></a>
                  <a href="#v-set-layout" rel="hdgrid"><i class="fa fa-th-large"></i></a>
                  <a href="#v-set-layout" rel="list" class="active"><i class="fa fa-th-list"></i></a>
                  <a href="#v-set-layout" rel="hdlist"><i class="fa fa-bars"></i></a>
                </div>
              </div>
              <div class="panel-block video-list list">
              

              @foreach($categoria as $video)
                <!-- BEGIN .item -->
                <div class="item">
                  <div class="item-header">
                    <a href="{{route('video.view.one', $video->id)}}" class="img-hover-effect loadingvideo"><img src="{{$video->featured_image}}" width="200" height="150" class="aspect-px" rel="{{$video->featured_image}}" alt="{{$video->title}}" /></a>
                  </div>
                  <div class="item-content">
                    <h3><a href="{{route('video.view.one', $video->id)}}">{{$video->title}}</a></h3>
                    <span class="video-meta">
                      <a href="{{route('video.view.one', $video->id)}}"><i class="fa fa-comment"></i>283</a>
                      <a href="{{route('video.view.one', $video->id)}}"><i class="fa fa-eye"></i>{{$video->views}}</a>
                      <a href="{{route('video.view.one', $video->id)}}"><i class="fa fa-heart"></i>{{$video->likes}}</a>
                    </span>
                    <p>{!! substr(strip_tags($video->description), 0, 200) !!}...</p>
                  </div>
                <!-- END .item -->
                </div>
              @endforeach

              <div class="clear-list-button" align="center">
                @if($categoria->previousPageUrl())
                  <a href="{{$categoria->previousPageUrl()}}" class="button">Pagina Anterior</a>
                @endif
                @if($categoria->nextPageUrl())
                  <a href="{{$categoria->nextPageUrl()}}" class="button">Siguiente Pagina</a>
                @endif
              </div>

              </div>
            </div>
        @else
         <h3 align="center">No se encontraron resultados. </h3>
        @endif
          <!-- END .with-sidebar-layout -->
          </div>
      
          <aside id="sidebar" class="right">

            <!-- BEGIN .widget -->
            

            <!-- BEGIN .widget -->
            <div class="widget">
              <div class="banner-widget no-border">
                <a href="#" target="_blank"><img src="images/no-banner-300x250.jpg" width="300" height="250" alt="" /></a>
                <a href="contact-us.html" class="banner-meta"><i class="fa fa-angle-double-up"></i> Contact us about advert spaces <i class="fa fa-angle-double-up"></i></a>
              </div>
            <!-- END .widget -->
            </div>

            @include('frontend.widgets.featured_videos')

            @include('frontend.widgets.popular_videos')


          <!-- END #sidebar -->
          </aside>
      </section>

@endsection  
@section('bottomscripts')
    <link rel="stylesheet" href="/vendor/comments/css/bootstrapless.css">
    <link rel="stylesheet" href="/vendor/comments/css/prism-okaidia.css"> <!-- Optional -->
    <link rel="stylesheet" href="/vendor/comments/css/comments.css">
    <script src="//cdn.jsdelivr.net/vue/1.0.16/vue.min.js"></script>

    <!-- Must be included before the closing </body> tag! -->
    <script src="/vendor/comments/js/utils.js"></script> 
    <script src="/vendor/comments/js/comments.js"></script>
      
    <script>
      new Vue({el: '#comments'});
      window.onload = function() {
        var video = document.getElementById('example_video_1');
        var thecanvas = document.getElementById('thecanvas');
        var img = document.getElementById('thumbnail_img');
      }
    </script>


  <style>
  li.comment.fade-transition {
      padding-right: 22px;
  }

  div.comment-content.clearfix {
      margin-left: -100px;
      width: 100%;
  }
  div.comment-text {
    margin-top: -50px;
}
video.video-js.vjs-default-skin.vjs-big-play-centered {
    margin-top: -35px;
}
div.footer {
    background-color: #292929;
}

div.item-content h4 a {
    color: #ffffff;
}

div.panel-content div h4 {
    color: #ffffff;
}



  </style>
@endsection     