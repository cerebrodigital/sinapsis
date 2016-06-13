    <!-- BEGIN .profile-left-side -->
    <div class="profile-left-side">

        <div class="the-profile-top">

            <div class="profile-user-name">
            <br>
                <h1>EDITAR PERFIL DE USUARIO: {!! $user->username !!}</h1>
                <div class="sttaa"><span>RECOMENDADO:</span>Lectura "<a href="forum-single.html">Aprender a hacer sinapsis y avanzar</a>"</div>
            </div>

            <div class="avatar online">
                <div class="avatar-button"><a href="#"><i class="fa fa-camera-retro"></i>Change Photo</a></div>
                <img src="http://www.gravatar.com/avatar/{{md5(strtolower(trim($user->email)))}}" width="215" class="setborder" alt="" />
            </div>
            
            <div>
                <ul class="user-button-list"><b></b></span></li>
                </ul>

                <div class="user-panel-about">
                    <div>
                        <b><i class="fa fa-male"></i>Acerca:</b>
                        <!--
                            <p>$user->user_profile->descripcion</p>
                            -->
                        <small>{!! $user->email !!}</small>
                    </div>

                    <div class="user-achievements">
                        <b><i class="fa fa-trophy"></i>Medallas (próximamente)</b>
                        <p>
                            <span class="ach strike-tooltip" title="Se unió a la comunidad"><i class="fa fa-unlock-alt"></i></span>
                            <span class="ach strike-tooltip" title="Here from beginning"><i class="fa fa-bar-chart-o"></i></span>
                            <span class="ach strike-tooltip" title="Activo en Foros"><i class="fa fa-comments-o"></i></span>
                            <span class="ach strike-tooltip" title="Escribe mucho"><i class="fa fa-keyboard-o"></i></span>
                            <span class="ach strike-tooltip" title="Aprobado como moderador"><i class="fa fa-thumbs-up"></i></span>
                            <span class="ach strike-tooltip" title="Ayuda a todos"><i class="fa fa-medkit"></i></span>
                            <span class="ach strike-tooltip" title="Ave nocturna"><i class="fa fa-moon-o"></i></span>
                            <span class="ach strike-tooltip" title="Gamer"><i class="fa fa-gamepad"></i></span>
                        </p>
                    </div>
                </div>

                <ul class="user-button-list">
                @if(\Auth::check())
                      @if(\Auth::user()->id == $user->id)
                            <li><a href="#edit" class="defbutton profile-button enabled"><i class="fa fa-wrench"></i>Change profile info</a></li>
                      @else
                            <li><a href="#mensajes" class="defbutton profile-button"><i class="fa fa-comment"></i>Private message</a></li>
                            @if(\Auth::user()->isFriendWith($user) == false)
                                @if(\Auth::user()->hasFriendRequestFrom($user) || $user->hasFriendRequestFrom(\Auth::user()) )
                                    <p>Tienes una invitación de amistad con este usuario. @if(\Auth::user()->hasFriendRequestFrom($user)) <b style="color:green;"><a href="{{route('profile.accept.friend', $user->id)}}">Aceptala</a> - <b style="color:red;"><a href="{{route('profile.deny.friend', $user->id)}}">Denegar Amistad</a></b>  @else <b>Espera que la acepten</b> @endif </p>
                                @else
                                    <form role="form" method="POST" action="{{route('profile.add.friend', $user->id)}}" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div align="center"><button type="submit" class="defbutton profile-button" ><i class="fa fa-coffee"></i>Enviar Solicitud de Amistad</button></div>
                                    </form>
                                @endif
                            @else
                                <p color="style:green"><b>Eres amigo de este usuario</b></p>
                                
                            @endif 
                        
                      @endif         
                    
                      @if(\Auth::user()->role == 'admin')  
                        <li><a href="#" class="defbutton profile-button disabled"><i class="fa fa-ban"></i>Ban this user</a></li>
                      @endif
                @endif
                </ul>
            </div>
        </div>
        
        <div class="the-profile-navi">
            <ul class="profile-navi">
            <br>
                
                @if( $user->user_profile->instagram || $user->user_profile->facebook || $user->user_profile->youtube || $user->user_profile->googleplus)
                    <h5>Links a Redes:</h5>
                    <li><a href="{{$user->user_profile->instagram}}" target="_blank"><i class="fa fa-instagram"></i>Visitar Instagram</a></li>
                    <li><a href="{{$user->user_profile->facebook}}" target="_blank"><i class="fa fa-facebook"></i>Visitar Facebook</a></li>
                    <li><a href="{{$user->user_profile->youtube}}" target="_blank"><i class="fa fa-youtube"></i>Visitar Youtube</a></li>
                    <li><a href="{{$user->user_profile->googleplus}}" target="_blank"><i class="fa fa-google"></i>Visitar Google Plus</a></li>
                @endif
            </ul>
            
            <div class="profile-panel instagram">
                <div class="pieces">

                </div>
                <div class="clear-float"></div>
            </div>
        </div>

    <!-- END .profile-left-side -->
    </div>