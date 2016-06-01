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
                    <li><span class="info-msg">The one who digs a hole, has a shovel!</span></li>
                </ul>

                <div class="user-panel-about">
                    <div>
                        <b><i class="fa fa-male"></i>About me</b>
                        <p>Cum no veri sententiae. Ei est primis melius admodum, at nisl nibh fugit cum, scaevola perpetua cu cum.</p>
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
                    <li><a href="messages-write.html" class="defbutton profile-button"><i class="fa fa-comment"></i>Private message</a></li>
                    <li><a href="#" class="defbutton profile-button"><i class="fa fa-coffee"></i>Follow him</a></li>
                    <li><a href="#edit" class="defbutton profile-button enabled"><i class="fa fa-wrench"></i>Change profile info</a></li>
                    <li><a href="#" class="defbutton profile-button disabled"><i class="fa fa-ban"></i>Ban this user</a></li>
                </ul>
            </div>
        </div>
        
        <div class="the-profile-navi">
            <ul class="profile-navi">
                <li><a href="#top"><span class="left-avatar"><img src="images/photos/avatar-1.jpg" alt="" /></span>Viewing <b>Datcouch</b> profile<br />Back to top<span class="clear-float"></span></a></li>
                <li class="active"><a href="user-single.html"><i class="fa fa-globe"></i>Profile information</a></li>
                <li><a href="user-single-guestbook.html"><i class="fa fa-comment-o"></i>Guest book</a></li>
                <li><a href="user-single-comments.html"><i class="fa fa-comment"></i>My comments</a></li>
                <li><a href="user-single-blog.html"><i class="fa fa-book"></i>Personal blog</a></li>
                <li><a href="user-single-music.html"><i class="fa fa-music"></i>Music playlist</a></li>
                <li><a href="user-single-friends.html"><i class="fa fa-users"></i>Friends<span class="notif">10</span></a></li>
                <li><a href="user-single-threads.html"><i class="fa fa-comments-o"></i>Forum topics<span class="notif">66</span></a></li>
                <li><a href="user-single-instagram.html"><i class="fa fa-camera-retro"></i>Instagram photos</a></li>
            </ul>
            
            <div class="profile-panel instagram">
                <div class="pieces">
                    <a href="https://instagram.com/marcisbee/" target="_blank"><img src="https://scontent-fra.cdninstagram.com/hphotos-xfp1/t51.2885-15/e15/10576140_778241095547266_331905980_n.jpg" alt="" /></a>
                    <a href="https://instagram.com/marcisbee/" target="_blank"><img src="https://scontent-fra.cdninstagram.com/hphotos-xpa1/outbound-distilleryimage1/t0.0-17/OBPTH/427393eef7af11e2b65722000a9e00be_7.jpg" alt="" /></a>
                    <a href="https://instagram.com/marcisbee/" target="_blank"><img src="https://scontent-fra.cdninstagram.com/hphotos-xpa1/outbound-distilleryimage5/t0.0-17/OBPTH/3259ed5670c711e2a9dd22000a9e29a7_7.jpg" alt="" /></a>
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
                    <li><a href="#" class="info-block"><b>1.2k</b><span>Sinapsis</span></a></li>
                    <li><a href="#" class="info-block"><b>29</b><span>Articulos</span></a></li>
                    <li><a href="#" class="info-block"><b>300</b><span>Publicaciones</span></a></li>
                    <li><a href="#" class="info-block"><b>23</b><span>Créditos</span></a></li>
                    <li><a href="#" class="info-block"><b>40</b><span>Puntos</span></a></li>
                    <li><span class="info-block"><b>777</b><span>Karma</span></span></li>
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
                    
                    <h2 style="margin-left: -30px;"><span>Friends (202)</span></h2>
                    
                    <ul class="profile-friends-list">
                        <li>
                            <a href="user-single.html" class="avatar online user-tooltip">
                                <img src="images/photos/avatar-1.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar online user-tooltip">
                                <img src="images/photos/avatar-2.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar away user-tooltip">
                                <img src="images/photos/avatar-4.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar ingame user-tooltip">
                                <img src="images/photos/avatar-5.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar offline user-tooltip">
                                <img src="images/photos/avatar-6.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar offline user-tooltip">
                                <img src="images/photos/avatar-7.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar offline user-tooltip">
                                <img src="images/photos/avatar-14.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar offline user-tooltip">
                                <img src="images/photos/avatar-15.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar offline user-tooltip">
                                <img src="images/photos/avatar-16.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar offline user-tooltip">
                                <img src="images/photos/avatar-17.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar offline user-tooltip">
                                <img src="images/photos/avatar-18.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                        <li>
                            <a href="user-single.html" class="avatar offline user-tooltip">
                                <img src="images/photos/avatar-19.jpg" class="setborder" title="" alt="" />
                            </a>
                        </li>
                    </ul>
                    <div class="clear-float"></div>

                    <a href="user-single-friends.html" class="defbutton"><i class="fa fa-users"></i>View all 202 friends</a>
                    
                </div>

                <div class="clear-float"></div>
            </div>
            
            <div class="photo-blocks">
                <ul>
                    <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments"><span>101</span></span><span class="article-image"><img src="http://distilleryimage10.s3.amazonaws.com/e7b6a2329d6f11e2be5722000a9f15cb_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                    <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments inactive"><span>23</span></span><span class="article-image"><img src="http://distilleryimage6.s3.amazonaws.com/74cada18729f11e2beb322000aaa0754_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                    <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments"><span>6</span></span><span class="article-image"><img src="http://distilleryimage5.s3.amazonaws.com/948b75cc967311e29b3722000a1fa50e_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                    <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments"><span>12</span></span><span class="article-image"><img src="http://distilleryimage11.s3.amazonaws.com/b62786f06ccd11e28a5622000a1fbe35_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                    <li><a href="user-single-instagram-single.html" class="article-image-out"><span class="image-comments inactive"><span>0</span></span><span class="article-image"><img src="http://distilleryimage8.s3.amazonaws.com/5e7dfe7270b811e286b422000a9d0dd8_6.jpg" width="128" height="128" alt="" title="" /></span></a></li>
                </ul>
                <div class="clear-float"></div>
            </div>
            
            <div>
                <center>
                    <a href="user-single-instagram.html" class="defbutton"><i class="fa fa-camera-retro"></i>View all instagram photos</a>
                </center>
            </div>
            
            <!-- BEGIN .music-blocks -->
            <div class="music-blocks">
                <ul>
                    <li>
                        <ol>
                            <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/AHitulGaS9k/default.jpg" alt=""></span><b>Jonas Brothers</b><span>Pom Poms</span><span class="clear-float"></span></a></li>
                            <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/vIAQuDkhXpQ/default.jpg" alt=""></span><b>Feint</b><span>Snake Eyes (Feat. CoMa)</span><span class="clear-float"></span></a></li>
                            <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/rNpBahr49mA/default.jpg" alt=""></span><b>Ellie Goulding</b><span>Figure 8</span><span class="clear-float"></span></a></li>
                        </ol>
                    </li>
                    <li>
                        <ol>
                            <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/4Xk_pViVP_k/default.jpg" alt=""></span><b>Foster The People</b><span>Don't Stop (TheFatRat Remix)</span><span class="clear-float"></span></a></li>
                            <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/qizlN1Ow1Fc/default.jpg" alt=""></span><b>JIKES &amp; Greg Cooke</b><span>Its Amazing</span><span class="clear-float"></span></a></li>
                            <li><a href="user-single-music-single.html"><span class="music-img"><img src="http://i4.ytimg.com/vi/FU4cnelEdi4/default.jpg" alt=""></span><b>Netsky</b><span>Puppy</span><span class="clear-float"></span></a></li>
                        </ol>
                    </li>
                </ul>
                <div class="clear-float"></div>
            <!-- END .music-blocks -->
            </div>
            
            <div>
                <center>
                    <a href="user-single-music.html" class="defbutton"><i class="fa fa-music"></i>View all songs</a>
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