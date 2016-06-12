@extends('frontend.master')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">Conectarse</h2>
              <ul>
                <li><a href="#home">Ir a Homepage</a></li>
                <li>Log in</li>
              </ul>
            </div>
          </div>
@endsection

@section('main')
<div class="signup-panel">

              <div class="left">
                <h2><span>CONECTARSE</span></h2>
                <div class="content-padding">
                  <p class="p-padding">Conectate para darle seguimiento a tu cuenta y acumular más puntos y subir niveles.</p>
                  <!--
                  <div class="login-passes">
                    <b>O puedes conectarte con:</b>
                    <a href="{{route('sinapsis.facebook.register')}}" class="strike-tooltip" title="Use Facebook.com passport"><img src="syn/images/social-icon-facebook.png" alt="" /></a>
                    <a href="{{route('sinapsis.github.register')}}" class="strike-tooltip" title="Usa Github para conectarte"><img src="syn/images/social-icon-github.png" alt="" /></a>
                    <a href="#" class="strike-tooltip" title="Use Steampowered.com passport"><img src="syn/images/social-icon-steam.png" alt="" /></a>
                    <a href="#" class="strike-tooltip" title="Use Google.com passport"><img src="syn/images/social-icon-google.png" alt="" /></a>
                  </div> -->
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                      <strong>Whoops!</strong> Hubieron problemas con las credenciales que introduciste. Intenta de nuevo.<br><br>
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                @endif
                  <div class="the-form" style="margin-top:10px;">

                          <form method="post" method="POST" action="{{ url('/auth/login') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <p>
                              <!-- <span class="the-error-msg"><i class="fa fa-warning"></i>You got an error</span> -->
                              <!-- <span class="the-success-msg"><i class="fa fa-check"></i>This is success</span> -->
                              <!-- <span class="the-alert-msg"><i class="fa fa-warning"></i>This is alert message</span> -->
                            </p>

                            <p>
                              <label for="email">Email:</label>
                              <input type="text" name="email" id="email" value="" />
                            </p>

                            <p>
                              <label for="password">Contrasela:</label>
                              <input type="password" name="password" id="password" value="" />
                            </p>

                            <p>
                              <label for="">&nbsp;</label>
                              <input type="checkbox" name="remember" id="remember" value="" />

                              <label class="iiiii" for="remember">Recuerdame</label>
                            </p>

                            <p class="form-footer">
                              <input type="submit" name="login_submit" id="login_submit" value="CONECTAR" />
                            </p>

                            <p style="margin-top:40px;">
                              <span class="info-msg">Si no tienes una cuenta, <a href="{{route('sinapsis.register.get')}}">REGISTRATE</a>
                              <br /><br />Si perdiste tu Constraseña <a href="{{route('sinapsis.password.reset')}}">click aqui</a> y te ayudaremos a resetearla.</span>
                            </p>

                          </form>
                  </div>

                </div>
              </div>

              <div class="right">
                <h2><span>¿QUE ES El PROYECTO SINAPSIS?</span></h2>
                <div class="content-padding">
                  
                  <div class="form-split-about">
                    <p class="p-padding">Cerebro Digital es un medio de difusión conocido en toda hispanoamerica.
                    Este proyecto es una app desarrollada usando Laravel 5.2, la cual unifica a los usuarios para
                    hacer "sinapsis", lo cual alegoricamente signicia "interacción" sin filtros, que almacena indicadores
                    que permitiran a un usuario ganar puntos de Experiencia, así como puntos de Reputación y posteriormente 
                    utilizarlos para tener muchas sorpresas gratis por interactuar y apoyar a los demás.
                    </p>

                    <ul>
                      <li>
                        <i class="fa fa-tasks"></i>
                        <b>Diferente Módulos</b>
                        <p class="p-padding">Existen los módulos de Artículos, Video, Media y Foros. Todos estos tienen métricas, sistemas de puntos y recompensas.</p>
                      </li>
                      
                      <li>
                        <i class="fa fa-trophy"></i>
                        <b>Sistema de recompensas</b>
                        <p class="p-padding">Un algoritmo de puntos, niveles, rangos y medallas permitirán ser premiado por tus aportes y ayuda a los demás usuarios.</p>
                      </li>

                      <li>
                        <i class="fa fa-microphone"></i>
                        <b>Tus proyectos y eventos tienen voz</b>
                        <p class="p-padding">Colabora en la comunidad, sube de nivel, date a conocer y tendrás accesos a difundir tus iniciativas, eventos o aportes al mundo de la educación en nuestra red de millones de usuarios.</p>
                      </li>
                    </ul>
                    
                  </div>
                  
                </div>
              </div>

              <div class="clear-float"></div>
            </div>


@endsection