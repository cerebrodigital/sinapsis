@extends('frontend.master')

@section('main')
<!-- BEGIN .user-profile -->
<div class="user-profile">
    
    <div class="profile-shadow"></div>
    @include('dashboard.start_left')

    <!-- BEGIN .profile-right-side -->
    <div class="profile-right-side">
        <?php $user_id = \Auth::user()->id; ?>
        <h2><span>LLENA TU PERFIL DE USUARIO PARA TENER MAYOR IMPACTO</span></h2>
        <div class="content-padding">
            <p>Para poder tener una mayor interacción en la comunidad procura llenar con links a todas tus redes, sitio web.</p>
        </div>
        <!-- BEGIN .content-padding -->
        <div class="content-padding">
            <form role="form" method="POST" action="{{route('profile.edit.post', $user_id)}}" enctype="multipart/form-data">
                <div class="form-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <label>Perfil de Facebook</label><br>
                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                    <input type="text" class="form-control" name="facebook" value="" placeholder="Facebook"> </div>
                    <label>Perfil de Youtube</label><br>
                    <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                    <input type="text" class="form-control" name="youtube" value="" placeholder="Youtube"> </div>
                    <label>Perfil de Instagram</label><br>
                    <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                    <input type="text" class="form-control" name="instagram" value="" placeholder="Instagram"> </div>
                    <label>Perfil de Google Plus</label><br>
                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                    <input type="text" class="form-control" name="googleplus" value="" placeholder="Google Plus"> </div>
                    <label>Descripcion de Perfil</label><br>
                    <textarea rows="4" cols="50" class="form-control" name="description"></textarea>
                        <br>
                        
                            <button type="submit" class="btn blue" style="float:right; font-size:20px">Continuar a mi Dashboard de Usuario</button>

                </div>
            </form>
        </div>
    </div>
    <div class="clear-float"></div>
</div>

@endsection

@section('bottomscripts')

    <script type='text/javascript'>
      var strike_autostart = false;
    </script>
@endsection