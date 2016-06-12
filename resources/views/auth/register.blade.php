@extends('frontend.master')


@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">Registrase</h2>
              <ul>
                <li><a href="#home">Ir a Homepage</a></li>
                <li>Registrarse</li>
              </ul>
            </div>
          </div>
@endsection

@section('main')
<div class="signup-panel">

              <div class="left">
                <h2><span>Registrate </span></h2>
                <div class="content-padding">
                  <p class="p-padding">Para ser parte de esta comunidad digital debes registrarte en esta aplicación con la cual unificamos y llevamos registro del aporte de todas nuestras neuronas.</p>

                  <div class="login-passes">
                    <b>Puedes conectarte con:</b>
                    <a href="{{route('sinapsis.facebook.register')}}" class="strike-tooltip" title="Use Facebook.com passport"><img src="syn/images/social-icon-facebook.png" alt="" /></a>
                    <a href="#" class="strike-tooltip" title="Use Twitter.com passport"><img src="syn/images/social-icon-twitter.png" alt="" /></a>
                    <a href="#" class="strike-tooltip" title="Use Steampowered.com passport"><img src="syn/images/social-icon-steam.png" alt="" /></a>
                    <a href="#" class="strike-tooltip" title="Use Google.com passport"><img src="syn/images/social-icon-google.png" alt="" /></a>
                  </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                          <strong>Whoops!</strong> There were some problems with your input.<br><br>
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                        </div>
                      @endif

                  <div class="the-form" style="margin-top:40px;">



                      <form action="" method="POST" action="{{ route('sinapsis.register.post') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <p>
                        <label for="username">Nombre de usuario:<span class="required">*</span></label>
                        <input type="text" name="username" id="username" value="" />
                      </p>

                      <p>
                        <label for="name">Nombre completo:<span class="required">*</span></label>
                        <input type="text" name="name" id="name" value="" />
                      </p>

                      <p>
                        <label for="email">E-mail:<span class="required">*</span></label>
                         <input class="error-input" type="text" name="email" id="email" value="" /> 
                        <!-- <span class="error-msg">E-mail must be filled !</span> -->
                      </p>

                      <p>
                        <label for="password">Contraseña:<span class="required">*</span></label>
                        <input type="password" name="password" id="password" value="" />
                      </p>

                      <p>
                        <label for="password_confirmation">Repetir contraseña:<span class="required">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" value="" />
                      </p>

                      <p class="form-footer">
                        <input type="submit" name="signup_submit" id="signup_submit" value="REGISTRARSE" />
                      </p>

                      <p>
                        <span class="info-msg">Si ya tienes una cuenta puedes <a href="{{url('/login')}}">CONECTARTE</a> !</span>
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