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

@endsection

@section('main')
<section >
        
        <!-- BEGIN .wrapper -->
        <div class="wrapper">
          
          <!-- BEGIN .with-sidebar-layout -->
          <div class="with-sidebar-layout left">


            <div class="content-panel">
               <p>
                 
                 @foreach($vids as $vid)
                    <p><a href="{{route('video.view.one', $vid->id)}}"><b>{{$vid->name}}</b></a></p>
                 @endforeach
                 
               </p>
             </div>



          <!-- END .with-sidebar-layout -->
          </div>

          <!-- BEGIN #sidebar -->
          <aside id="sidebar" class="right">

           

            <!-- BEGIN .widget -->



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