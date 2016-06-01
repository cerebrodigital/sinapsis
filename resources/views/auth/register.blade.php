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
                <h2><span>Log in</span></h2>
                <div class="content-padding">
                  <p class="p-padding">An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</p>

                  <div class="login-passes">
                    <b>O puedes usar los passports:</b>
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
                        <label for="password">Password:<span class="required">*</span></label>
                        <input type="password" name="password" id="password" value="" />
                      </p>

                      <p>
                        <label for="password_confirmation">password repeat:<span class="required">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" value="" />
                      </p>

                      <p class="form-footer">
                        <input type="submit" name="signup_submit" id="signup_submit" value="REGISTRARSE" />
                      </p>

                      <p>
                        <span class="info-msg">If you already have an account please <a href="login.html">log in</a> !</span>
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