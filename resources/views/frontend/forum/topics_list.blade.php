@extends('frontend.master_forum')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right"><u>Listado de todos los últimos topics</u></h2>
              <ul class="left">
                <li><a href="#home">FORO</a></li>
                <li>Topic</li>
              </ul>
            </div>
          </div>
@endsection



@section('main')
<div id="main">
  <div class="forum-block">

              <!-- <h2><span>Otro titulo de la pagina</span></h2> -->
              
              <div class="content-padding">
                <div class="forum-description">
                  <div class="pagination right">
                    <a href="#" class="page-num">1</a>
                    <span class="page-num current">2</span>
                    <a href="#" class="page-num">3</a>
                    <a href="#" class="page-num">4</a>
                    <a href="#" class="page-num">5</a>
                    <span class="page-num page-hidden">...</span>
                    <a href="#" class="page-num">74</a>
                  </div>

                  <a href="{{route('foro.create.view')}}" class="defbutton big"><i class="fa fa-comment-o"></i>CREAR UN NUEVO TEMA</a>
                </div>
              </div>

              <div class="forum-threads-head">
                <strong class="thread-subject"><span>Tema</span></strong>
                <strong class="thread-author">Autor</strong>
                <strong class="thread-replies">Respuestas</strong>
                <strong class="thread-views">Vistas</strong>
                <strong class="thread-last">Última respuesta</strong>
              </div>
              <!-- BEGIN .forum-threads -->
              <div class="forum-threads">
              @foreach($topics as $topic)
                <!-- BEGIN .thread-link -->
                <div class="thread-link thread-unread thread-sticky">
                  <a href="{{route('foro.topic.id', $topic->id)}}">
                  @if(count($topic->messages) > 0)
                    <i class="forum-icon strike-tooltip" title="Topic has answers"> 
                      <i class="fa fa-comments-o"></i>
                    </i>
                  @endif
                    <span>@if($topic->pinned == '1')<i class="sticky">PIN</i>@endif {{$topic->title}}</span>
                  </a>
                  <div class="thread-author">
                    <span class="f-user-link"><a href="{{route('dashboard.profile', $topic->author->id)}}"><strong>{{$topic->author->username}}</strong></a></span>
                  </div>
                  <div class="thread-replies">
                    <span>{{count($topic->messages)}}</span>
                  </div>
                  <div class="thread-views">
                    <span>{{$topic->views}}</span>
                  </div>
                  <div class="thread-last">
                  @if(count($topic->messages) >0)
                    <span class="f-user-link"><a href="user-single.html"><strong>autor</strong></a></span>
                    <span class="t-date">fecha</span>
                  @else
                    <span class="t-date">ninguna respuesta aun</span>
                  @endif
                  </div>
                <!-- END .thread-link -->
                </div>
              @endforeach
              <!-- END .forum-threads -->
              </div>
              
              <div class="content-padding">
                <div class="forum-description">
                  <div class="pagination right">
                  {!!$topics->render()!!}
                  </div>

                  <a href="{{route('foro.create.view')}}" class="defbutton big"><i class="fa fa-comment-o"></i>CREAR UN NUEVO TEMA</a>
                </div>
              </div>

            </div>
</div>
@endsection  

@section('sidebar')
  <aside id="sidebar" >
    <div class="panel">
      @include('frontend.widgets.forum.categories')
    </div>
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

      $(document).ready(function() {
        var initEditor = function() {
          $("#message").sceditor({
            plugins: 'bbcode',
            style: "/foro/minified/jquery.sceditor.modern.min.css"
          });
        };
        initEditor();
      });

    </script>
    <style>
      li.comment.fade-transition {
          padding-right: 22px;
      }

      div.comment-content.clearfix {
          margin-left: -100px;
          width: 100%;
      }
      div.user-block {
          padding-right: 10px;
      }

      div.post-text-block {
          padding-left: 5px;
      }
    </style>
@endsection  