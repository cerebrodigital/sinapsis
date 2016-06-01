@extends('frontend.master_video')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">HOME</h2>
              <ul>
                <li><a href="#home">Media</a></li>
                <li>Videos</li>
              </ul>
            </div>
          </div>
@endsection


@section('video')
<!-- BEGIN .video-slider -->
        <div class="video-slider">
          <!-- BEGIN .wrapper -->
          <div class="wrapper">
            <div class="slider-controls">
              <a href="#" class="ot-slider-control-left"><i class="fa fa-angle-left"></i></a>
              <a href="#" class="ot-slider-control-right"><i class="fa fa-angle-right"></i></a>
              <div class="video-slider-inline">

                <div class="otplayer-wrapper">
                  <a href="index.html" class="video-overlay-logo"><img src="images/overlay-logo.png" width="123" height="28" alt="" /></a>
                  <video class="otplayer" preload="auto" poster="http://videomag.orange-themes.com/html/video/video-screen.png">
                    <source src="http://videomag.orange-themes.com/html/video/sintel-2048-surround.mp4" type="video/mp4">
                    <div id="videofallback">Loading the player...</div>
                  </video>

                  <div class="otplayer-controls">
                    <div class="ot-inline-playpause"><i class="fa fa-play"></i><i class="fa fa-pause"></i></div>
                    <div class="ot-inline-slider"><div></div></div>
                    <div class="ot-inline-time">00:00</div>
                    <div class="ot-inline-volume-controls">
                      <div class="ot-inline-volume">
                        <i class="fa fa-volume-up"></i>
                        <i class="fa fa-volume-off"></i>
                      </div>
                      <div class="ot-inline-volume-slider"><div></div></div>
                    </div>
                    <div class="ot-inline-fullscreen"><i class="fa fa-desktop"></i></div>
                  </div>
                </div>

              </div>
            </div>
            <div class="video-slider-meta">
              <div class="video-slider-info right">
                <a href="post.html" class="meta-click"><i class="fa fa-comments"></i> <strong>283</strong> comments</a>
                <a href="post.html" class="meta-click"><i class="fa fa-eye"></i> <strong>829</strong> views</a>
                <a href="#" class="ot-like-button"><i class="fa fa-heart"></i> Like This Video</a>
              </div>
              <h3><a href="post.html">Sintel</a></h3>
            </div>
          <!-- END .wrapper -->
          </div>
          <div class="video-slider-slides">

            <div class="video-slides-inner">

              <a href="#video-lalala" class="item" rel="vimeo">
                <span class="slider-image left loadingvideo"><img src="images/aspect-px.png" width="16" height="9" class="aspect-px" rel="http://b.vimeocdn.com/ts/111/443/111443121_295.jpg" alt="" /></span>
                <span class="slider-content">
                  <strong>Seat Ibiza</strong>
                  <span>Ne mei illud quidam labitur, adhuc clita quo. Vim oportere gubergren.</span>
                  <span class="video-meta">
                    <span><i class="fa fa-comment"></i>283</span>
                    <span><i class="fa fa-eye"></i>829</span>
                    <span><i class="fa fa-heart"></i>95</span>
                  </span>
                </span>
              </a><!--

             --><a href="#video-123" class="item" rel="vimeo">
                <span class="slider-image left loadingvideo"><img src="images/aspect-px.png" width="16" height="9" class="aspect-px" rel="http://b.vimeocdn.com/ts/803/220/8032208_295.jpg" alt="" /></span>
                <span class="slider-content">
                  <strong>Imagine</strong>
                  <span>Ne mei illud quidam labitur, adhuc clita quo. Vim oportere gubergren.</span>
                  <span class="video-meta">
                    <span><i class="fa fa-comment"></i>283</span>
                    <span><i class="fa fa-eye"></i>829</span>
                    <span><i class="fa fa-heart"></i>95</span>
                  </span>
                </span>
              </a><!--
              
             --><a href="#video-555" class="item" rel="vimeo">
                <span class="slider-image left loadingvideo"><img src="images/aspect-px.png" width="16" height="9" class="aspect-px" rel="http://b.vimeocdn.com/ts/755/212/75521247_295.jpg" alt="" /></span>
                <span class="slider-content">
                  <strong>TRI▲NGLE</strong>
                  <span>Ne mei illud quidam labitur, adhuc clita quo. Vim oportere gubergren.</span>
                  <span class="video-meta">
                    <span><i class="fa fa-comment"></i>283</span>
                    <span><i class="fa fa-eye"></i>829</span>
                    <span><i class="fa fa-heart"></i>95</span>
                  </span>
                </span>
              </a><!--
              
             --><a href="#12345" class="item" rel="vimeo">
                <span class="slider-image left loadingvideo"><img src="images/aspect-px.png" width="16" height="9" class="aspect-px" rel="http://b.vimeocdn.com/ts/150/225/150225328_295.jpg" alt="" /></span>
                <span class="slider-content">
                  <strong>The Node</strong>
                  <span>Ne mei illud quidam labitur, adhuc clita quo. Vim oportere gubergren.</span>
                  <span class="video-meta">
                    <span><i class="fa fa-comment"></i>283</span>
                    <span><i class="fa fa-eye"></i>829</span>
                    <span><i class="fa fa-heart"></i>95</span>
                  </span>
                </span>
              </a><!--
              
             --><a href="#play-oo" class="item" rel="vimeo">
                <span class="slider-image left loadingvideo"><img src="images/aspect-px.png" width="16" height="9" class="aspect-px" rel="http://b.vimeocdn.com/ts/122/932/122932430_295.jpg" alt="" /></span>
                <span class="slider-content">
                  <strong>I'm a monster</strong>
                  <span>Ne mei illud quidam labitur, adhuc clita quo. Vim oportere gubergren.</span>
                  <span class="video-meta">
                    <span><i class="fa fa-comment"></i>283</span>
                    <span><i class="fa fa-eye"></i>829</span>
                    <span><i class="fa fa-heart"></i>95</span>
                  </span>
                </span>
              </a>

            </div>

          </div>
        <!-- END .video-slider -->
        </div>
@endsection

@section('main')
<section >
        
        <!-- BEGIN .wrapper -->
        <div class="wrapper">
          
          <!-- BEGIN .with-sidebar-layout -->
          <div class="with-sidebar-layout left">


            <div class="content-panel">
               @include('frontend.widgets.video.latest')

               @include('frontend.widgets.video.popular')
             </div>



          <!-- END .with-sidebar-layout -->
          </div>

          <!-- BEGIN #sidebar -->
          <aside id="sidebar" class="right">

           

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
          
        <!-- END .wrapper -->
        </div>
        
      <!-- BEGIN .content -->
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
    <script>new Vue({el: '#comments'});
      window.onload = function() {
        document.querySelector('#example_video_1').play()
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
    margin-top: -40px;
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