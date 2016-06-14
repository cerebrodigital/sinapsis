@extends('frontend.master_forum')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right"><u>{{$topic->title}}</u></h2>
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
              
              <div class="content-padding">
                <div class="forum-description">
                  <div style="float:right;"><a href="{{route('topic.like', $topic->id)}}" class="loveBtn" style="color:white;font-size:15px"><i class="fa fa-heart" style="color:white;" aria-hidden="true"></i><b> Favorito ({{$topic->likeCount}})</b></a></div>
                  <div class="topic-right right">
                    <span><i class="fa fa-eye"> vistas: {{$topic->views}}</i></span> -
                    <span>{{count($topic->messages)}} Respuestas</span>
                  </div>

                  <a href="#quick-reply" class="newdefbutton margin-right scroll"><i class="fa fa-comment-o"></i>Responder</a>
                  <!--
                    <a href="#" class="newdefbutton margin-right admin-color"><i class="fa fa-unlock"></i>Bloquear</a>
                     <a href="#" class="newdefbutton margin-right admin-color"><i class="fa fa-lock"></i>Close Thread</a> 
                    <a href="#" class="newdefbutton margin-right admin-color"><i class="fa fa-level-up"></i>Pin</a>
                     <a href="#" class="newdefbutton margin-right admin-color"><i class="fa fa-level-down"></i>Unpin</a> 
                  -->
                </div>
              </div>

              <!-- BEGIN .forum-thread -->
              <div class="forum-thread">

                <!-- BEGIN .forum-post -->
                <div class="forum-post" id="post-1" style="background-color:#fffddc;">
                  <div class="user-block">
                    <a href="user-single.html" class="avatar online user-tooltip">
                      <img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($topic->author->email))); ?>" class="setborder" title="" alt="" />
                    </a>
                    <div class="user-account">
                      <div>
                        <a href="user-single.html" class="forum-user user-tooltip"><b>{{$topic->author->username}}</b></a>
                      </div>
                        <div>
                          <small>Exp: <small class="rating-good">{{$topic->author->experience}}</small></small>
                        </div>
                        <div>
                          <small>Rep: <small class="rating-bad">{{$topic->author->experience}}</small></small>
                        </div>
                        <div>
                          <small style="color:black;">amigos(<small >{{$topic->author->getFriends()->count()}}</small>)</small>
                        </div>
                    </div>
                    <div class="clear-float"></div>
                  </div>
                  <div class="post-text-block">
                    {!!$topic->message!!}
                    <div class="post-signature">
                      <p>Small signature</p>
                    </div>
                  </div>
                  <div class="post-meta-block">
                    <div>
                      <a href="#post-{{$topic->id}}">#{{$topic->id}}</a>
                    </div>
                    <div>
                      <span class="post-date">{{$topic->created_at}}</span>
                    </div>
                    <div>
                      <a href="#" class="strike-tooltip" title="Positive"><i class="fa fa-thumbs-up rating-good"></i></a>
                      <span class="the-rate rating-good">101</span>
                      <a href="#" class="strike-tooltip" title="Negative"><i class="fa fa-thumbs-down rating-bad"></i></a>
                    </div>
                    <!-- <div>
                      <a href="#"><i class="fa fa-thumbs-up rating-good"></i></a>
                      <span class="the-rate rating-bad">-20</span>
                      <a href="#"><i class="fa fa-thumbs-down rating-bad"></i></a>
                    </div> -->
                    <div class="bottom">
                      <a href="#" class="defbutton admin-color"><i class="fa fa-trash-o"></i></a>
                      <a href="#" class="defbutton admin-color"><i class="fa fa-pencil"></i></a>
                      <a href="#quick-reply" class="defbutton scroll"><i class="fa fa-comment-o"></i>Reply</a>
                    </div>
                  </div>
                <!-- END .forum-post -->
                </div>




                <!-- COMIENZA LOS MENSAJES .forum-post -->
              @if($topic->messages)
                @foreach($topic->messages as $message)
                  <div class="forum-post" id="post-2">
                    <div class="user-block">
                      <a href="user-single.html" class="avatar offline user-tooltip">
                        <img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($message->author->email))); ?>" class="setborder" title="" alt="" />
                      </a>
                      <div class="user-account">
                        <div>
                          <a href="user-single.html" class="forum-user user-tooltip"><b>{{$message->author->username}}.</b></a>
                        </div>
                        <div>
                          <small>Exp: <small class="rating-good">{{$message->author->experience}}</small></small>
                        </div>
                        <div>
                          <small>Rep: <small class="rating-bad">{{$message->author->experience}}</small></small>
                        </div>
                        <div>
                          <small style="color:black;">amigos(<small >{{$message->author->getFriends()->count()}}</small>)</small>
                        </div>
                      </div>
                      <div class="clear-float"></div>
                    </div>
                    <div class="post-text-block">
                      {!!$message->message!!}

                      <!-- <div class="comment-edited">
                        <span><i class="fa fa-pencil"></i>Edited by <a href="user-single.html" class="user-tooltip"><b>datcouch</b></a>, 11:22, Sep 11, 2012</span>
                      </div>
                      -->
                    </div>
                    <div class="post-meta-block">
                      <div>
                        <a href="#post-{{$message->id}}">#{{$message->id}}</a>
                      </div>
                      <div>
                        <span class="post-date">{{$message->created_at}}</span>
                      </div>
                      <!-- <div>
                        <a href="#" class="strike-tooltip" title="Positive"><i class="fa fa-thumbs-up rating-good"></i></a>
                        <span class="the-rate rating-good">101</span>
                        <a href="#" class="strike-tooltip" title="Negative"><i class="fa fa-thumbs-down rating-bad"></i></a>
                      </div> -->
                      <div>
                        <a href="#"><i class="fa fa-thumbs-up rating-good"></i></a>
                        <span class="the-rate rating-bad">-20</span>
                        <a href="#"><i class="fa fa-thumbs-down rating-bad"></i></a>
                      </div>
                      <div class="bottom">
                        <a href="#quick-reply" class="defbutton scroll"><i class="fa fa-comment-o"></i>Reply</a>
                      </div>
                    </div>
                  <!-- END .forum-post -->
                  </div>
                @endforeach
              @else 
                <div class="post-text-block">
                <h4>Aún no existe ninguna respuesta a este hilo.</h4>
                </div>
              @endif
              <!-- END .forum-thread -->
              </div>
              
              <div class="content-padding quick-reply" id="quick-reply">
                <div class="forum-description">
                @if(!\Auth::check())
                    <h4>Necesitas estar conectado para poder publicar un mensaje</h4>
                    <a href="{{url('/login')}}"><button type="submit" align="center" class="btn blue" style="font-size:17px;">CONECTAR</button></a>

                @else
                  <div id="response-message">
                    <form role="form" method="POST" action="{{route('foro.topic.reply', $topic->id)}}" enctype="multipart/form-data">
                      <p>Hola {{\Auth::user()->name}} ¿quieres responder?</p>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <textarea name="message" id="message" style="height:300px;width:100%;"></textarea>
                      <br>
                      <button type="submit" align="center" class="btn blue" style="font-size:17px;">PUBLICAR RESPUESTA</button>
                     </form>
                  </div>
                @endif

                </div>
                <div class="reply-box">
                    
                </div>
              </div>
              
              <div class="content-padding">
                <div class="forum-description">
                  <div class="pagination right">
                    <span class="page-num current">1</span>
                    <a href="#" class="page-num">2</a>
                    <a href="#" class="page-num">3</a>
                  </div>
                  @if($topic->status == "closed")
                    <div class="topic-right right">
                      <span><i class="fa fa-unlock-alt"></i>Tema Cerrado</span>
                      <span></span>
                    </div>
                  @endif
                </div>
              </div>

            </div>
  <!-- END .content-padding -->
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