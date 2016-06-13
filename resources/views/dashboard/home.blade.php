@extends('frontend.master')

@section('main')
<!-- BEGIN .user-profile -->
<div class="user-profile">
    
    <div class="profile-shadow"></div>

    <!-- BEGIN .profile-left-side -->
    <div class="profile-left-side">

        <div class="the-profile-top">

            <div class="profile-user-name">
            <br>
                <h1>{!! \Auth::user()->name !!}</h1>
                <div class="sttaa"><span>RECOMENDADO:</span>Lectura "<a href="forum-single.html">Aprender a hacer sinapsis y avanzar</a>"</div>
            </div>

            <div class="avatar online">
                <div class="avatar-button"><a href="#"><i class="fa fa-camera-retro"></i>Change Photo</a></div>
                <img src="http://www.gravatar.com/avatar/{{md5(strtolower(trim(\Auth::user()->email)))}}" width="215" class="setborder" alt="" />
            </div>
            
            <div>
                <ul class="user-button-list">
                    <li><span class="info-msg">Titulo: <b>{{ \Auth::user()->user_profile->titulo}}</b></span></li>
                </ul>

                <div class="user-panel-about">
                    <div>
                        <b><i class="fa fa-male"></i>Acerca de mi</b>
                        <p>{{ \Auth::user()->user_profile->descripcion}}</p>
                        <small>{!! \Auth::user()->email !!}</small>
                    </div>

                    <div class="user-achievements">
                        <b><i class="fa fa-trophy"></i>My achievements</b>
                        <p>
                            <span class="ach strike-tooltip" title="Joined Revelio"><i class="fa fa-unlock-alt"></i></span>
                            <span class="ach strike-tooltip" title="Here from beginning"><i class="fa fa-bar-chart-o"></i></span>
                            <span class="ach strike-tooltip" title="Active on forums"><i class="fa fa-comments-o"></i></span>
                            <span class="ach strike-tooltip" title="Writes a lot"><i class="fa fa-keyboard-o"></i></span>
                            <span class="ach strike-tooltip" title="Admin aproved"><i class="fa fa-thumbs-up"></i></span>
                            <span class="ach strike-tooltip" title="Helps everyone"><i class="fa fa-medkit"></i></span>
                            <span class="ach strike-tooltip" title="Night owl"><i class="fa fa-moon-o"></i></span>
                            <span class="ach strike-tooltip" title="Comes and plays"><i class="fa fa-gamepad"></i></span>
                        </p>
                    </div>
                </div>

                <ul class="user-button-list">
                    <li><a href="messages-write.html" class="defbutton profile-button"><i class="fa fa-edit"></i>Editar Perfil</a></li>

                </ul>
            </div>
        </div>
        
        <div class="the-profile-navi">
            <ul class="profile-navi">
            <br>
                <h5>Links a Redes:</h5>
                <li><a href="{{\Auth::user()->user_profile->instagram}}" target="_blank"><i class="fa fa-instagram"></i>Visitar Instagram</a></li>
                <li><a href="{{\Auth::user()->user_profile->facebook}}" target="_blank"><i class="fa fa-facebook"></i>Visitar Facebook</a></li>
                <li><a href="{{\Auth::user()->user_profile->youtube}}" target="_blank"><i class="fa fa-youtube"></i>Visitar Youtube</a></li>
                <li><a href="{{\Auth::user()->user_profile->googleplus}}" target="_blank"><i class="fa fa-google"></i>Visitar Google Plus</a></li>
            </ul>
            
            <div class="profile-panel instagram">
                <div class="pieces">

                </div>
                <div class="clear-float"></div>
            </div>
        </div>

    <!-- END .profile-left-side -->
    </div>

    <!-- BEGIN .profile-right-side -->
    <div class="profile-right-side">

        <h2><span>Logros y avances de este usuario</span></h2>
        <!-- BEGIN .content-padding -->
        <div class="content-padding">

            <!-- BEGIN .info-blocks -->
            <div class="info-blocks">
                <ul>
                    <li><a href="#" class="info-block"><b>{{$user->experience}}</b><span>Exp</span></a></li>
                    <li><span class="info-block"><b>777</b><span>Rep</span></span></li>
                    <li><a href="#" class="info-block"><b>{{$user->posts()->count()}}</b><span>Articulos</span></a></li>
                    <li><a href="#" class="info-block"><b>{{$user->videos()->count()}}</b><span>Videos</span></a></li>
                    <li><a href="#" class="info-block"><b>{{$user->topics()->count()}}</b><span>Temas Foro</span></a></li>
                    <li><a href="#" class="info-block"><b>{{$user->replies()->count()}}</b><span>Respuestas</span></a></li>
                    
                </ul>
                <div class="clear-float"></div>
            <!-- END .info-blocks -->
            </div>
            
            <div>
                <div style="width:350px;" class="left">
                    <h2 style="margin-left:-30px;"><span>Profile Information</span></h2>
                    
                    <ul class="profile-info">
                        <li>
                            <span class="first">Name, Surname:</span>
                            <span class="last">{!! \Auth::user()->name !!}</span>
                        </li>
                                                <li>
                            <span class="first">Birthday:</span>
                            <span class="last">11.September, 1992</span>
                        </li>
                        <li>
                            <span class="first">Location:</span>
                            <span class="last">United Kingdom, London</span>
                        </li>
                        <li>
                            <span class="first">Última actualización::</span>
                            <span class="last">({!! \Auth::user()->updated_at !!})</span>
                        </li>
                        <li>
                            <span class="first">Signed up:</span>
                            <span class="last">({!! \Auth::user()->created_at !!})</span>
                        </li>
                        <tr>
                            <th>Acciones Generales</th>
                            <td>
                                <a href="#" class="btn btn-primary btn-xs">Informacion editar</a>

                                
                                    <a href="#cambiar" class="btn btn-warning btn-xs">Cambiar Contraseña</a>
                                
                            </td>
                        </tr>
                    </ul>

                    <div class="clear-float"></div>
                </div>

                <div style="width:300px;" class="right">
                    <?php
                        $friends = \Auth::user()->getFriends()->take(12);
                        $total_friends = \Auth::user()->getFriends()->count();
                    ?>
                    <h2 style="margin-left: -30px;"><span>Amistades ({{$total_friends}})</span></h2>
                    <ul class="profile-friends-list">
                    @foreach($friends as $friend)
                        <li>
                            <a href="{{route('dashboard.profile',$friend->id)}}" class="avatar online user-tooltip">
                                <img src="http://www.gravatar.com/avatar/{{md5(strtolower(trim($friend->email)))}}" class="setborder" height="40" title="" alt="" />
                            </a>
                        </li>
                    @endforeach
                    </ul>
                    <div class="clear-float"></div>
                    @if(count($total_friends) > 12)
                        <a href="#veramistades" class="defbutton"><i class="fa fa-users"></i>Ver todas las amistades</a>
                    @endif
                </div>

                <div class="clear-float"></div>
            </div>
            
            
            <!-- BEGIN .music-blocks -->
            <div class="music-blocks">
                <ul>
                
                    <li>
                        <ol>
                        @if($user->posts()->count() > 0)
                            <h4>Artículos publicados</h4>
                            @foreach($user->posts()->take(4)->get() as $post)
                                <li><a href="user-single-music-single.html"><span class="music-img"><img src="{{$post->featured_image}}" alt="" height="40"></span><b>{{$post->title}}</b><span>Pom Poms</span><span class="clear-float"></span></a></li>
                            @endforeach
                        @else
                            <h4>Este usuario no tiene Artículos publicados</h4>
                        @endif
                        </ol>
                    </li>
                    <li>
                        <ol>
                        @if($user->videos()->count() > 0)
                            <h4>Videos publicados</h4>
                            @foreach($user->videos()->take(4)->get() as $video)
                                <li><a href="user-single-music-single.html"><span class="music-img"><img src="{{$video->featured_image}}" alt=""></span><b>{{$video->title}}</b><span>Pom Poms</span><span class="clear-float"></span></a></li>
                            @endforeach
                        @else
                            <h4>Este usuario no tiene videos publicados</h4>
                        @endif
                        </ol>
                    </li>
                
                </ul>
                <div class="clear-float"></div>
            <!-- END .music-blocks -->
            </div>
            
            <div>
                <center>
                    <a href="#vermas" class="defbutton"><i class="fa fa-more"></i>Ver más artículos y videos</a>
                </center>
            </div>
            
        <!-- END .content-padding -->
        </div>


        <h2><span>Comentarios de tu Perfil</span></h2>
        <!-- BEGIN .content-padding -->
        <div class="content-padding">
            
            @include('comments::display', ['pageId' => \Auth::user()->email])
        </div>

    <!-- END .profile-right-side -->
    </div>

    <div class="clear-float"></div>

<!-- END .user-profile -->
</div>

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
@endsection