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
                  <p class="p-padding">An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>

                  <div class="login-passes">
                    <b>O puedes conectarte con:</b>
                    <a href="{{route('sinapsis.facebook.register')}}" class="strike-tooltip" title="Use Facebook.com passport"><img src="syn/images/social-icon-facebook.png" alt="" /></a>
                    <a href="{{route('sinapsis.github.register')}}" class="strike-tooltip" title="Usa Github para conectarte"><img src="syn/images/social-icon-github.png" alt="" /></a>
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
                              <label for="password">Password:</label>
                              <input type="password" name="password" id="password" value="" />
                            </p>

                            <p>
                              <label for="">&nbsp;</label>
                              <input type="checkbox" name="remember" id="remember" value="" />

                              <label class="iiiii" for="remember">Recuerdame</label>
                            </p>

                            <p class="form-footer">
                              <input type="submit" name="login_submit" id="login_submit" value="Log in" />
                            </p>

                            <p style="margin-top:40px;">
                              <span class="info-msg">Si no tienes una cuenta, <a href="{{route('sinapsis.register.get')}}">REGISTRATE</a>
                              <br /><br />If lost password <a href="{{route('sinapsis.password.reset')}}">click aqui</a> y te ayudaremos a resetearlo.</span>
                            </p>

                          </form>
                  </div>

                </div>
              </div>

              <div class="right">
                <h2><span>¿QUE ES SINAPSIS DIGITAL?</span></h2>
                <div class="content-padding">
                  
                  <div class="form-split-about">
                    <p class="p-padding">Lorem ipsum dolor sit amet, natum referrentur sea no. Sensibus definitionem necessitatibus id vim, eu ornatus intellegat argumentum nam. Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>

                    <ul>
                      <li>
                        <i class="fa fa-picture-o"></i>
                        <b>Id ius facete urbanitas concludaturque mea</b>
                        <p class="p-padding">Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua.</p>
                      </li>
                      
                      <li>
                        <i class="fa fa-trophy"></i>
                        <b>Id ius facete urbanitas concludaturque mea</b>
                        <p class="p-padding">Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>
                      </li>

                      <li>
                        <i class="fa fa-microphone"></i>
                        <b>Id ius facete urbanitas concludaturque mea</b>
                        <p class="p-padding">Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>
                      </li>
                      
                      <li>
                        <i class="fa fa-comments"></i>
                        <b>Id ius facete urbanitas concludaturque mea</b>
                        <p class="p-padding">Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua.</p>
                      </li>
                    </ul>
                    
                  </div>
                  
                </div>
              </div>

              <div class="clear-float"></div>
            </div>


@endsection