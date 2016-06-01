@extends('frontend.master')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">Recuperar Contraseña</h2>
              <ul>
                <li><a href="#home">Ir a Homepage</a></li>
                <li>Log in</li>
              </ul>
            </div>
          </div>
@endsection

@section('main')
<!-- BEGIN .signup-panel -->
<div class="signup-panel">
  
  <!-- BEGIN .left -->
  <div class="left">
    <h2><span>Recuperar contraseña</span></h2>
    <div class="content-padding">
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif

      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <strong>Whoops!</strong> Hay algunos errores con el envio.<br><br>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      
      <div class="the-form" style="margin-top:40px;">
        <form role="form" method="POST" action="{{ url('/password/email') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <p>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" value="" />
          </p>

          <p class="form-footer">
            <input type="submit" name="forgot_submit" id="forgot_submit" value="Enviar una llave a tu email" />
          </p>

          <p style="margin-top:40px;">
            <span class="info-msg">Lorem ipsum dolor sit amet, natum referrentur sea no. Sensibus definitionem necessitatibus id vim, eu ornatus intellegat argumentum nam. Ius modo interpretaris at, alia erat pri te. An euripidis assentior accommodare usu, ut eam fabellas facilisi perpetua. Accumsan scripserit cu mel, ut dolorem adolescens per.</span>
          </p>

        </form>
      </div>

    </div>
  <!-- END .left -->
  </div>

  <!-- BEGIN .right -->
  <div class="right">
    <h2><span>¿Como funciona esto?</span></h2>
    <div class="content-padding">
      
      <div class="form-split-about">
        <p class="p-padding">Recibiras un email con una llave, da click ahi para resetear:</p>
        
        <ul>
          <li>
            <font>1.</font>
            <b>Recibes un email con la llave</b>
            <p class="p-padding">Esta llave es generada y se vence en 24 horas</p>
          </li>
          
          <li>
            <font>2.</font>
            <b>Dale click al link del correo</b>
            <p class="p-padding">Te enviará a una pagina</p>
          </li>

          <li>
            <font>3.</font>
            <b>Cambia tu password</b>
            <p class="p-padding">Sensibus definitionem necessitatibus id vim, eu ornatus intellegat argumentum nam</p>
          </li>
        </ul>

      </div>

    </div>
  <!-- END .left -->
  </div>

  <div class="clear-float"></div>

<!-- END .signup-panel -->
</div>
@endsection