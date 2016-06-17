@extends('frontend.master')

@section('main')
<!-- BEGIN .user-profile -->
<?php
        $user_id = \Auth::user()->id;
?>

<div class="user-profile">
    
    <div class="profile-shadow"></div>

    @include('dashboard.profile_left', ['user' => $user])

    <!-- BEGIN .profile-right-side -->
    <div class="profile-right-side">
        <h2><span>LLENA TU PERFIL DE USUARIO PARA TENER MAYOR IMPACTO</span></h2>
        <!-- BEGIN .content-padding -->
        <div class="content-padding">
            <form role="form" method="POST" action="{{route('profile.edit.post', $user_id)}}" enctype="multipart/form-data">
                <div class="form-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <label>Nombre de Usuario</label><br>
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control" name="title" value="{{$user->name}}" placeholder="Nombre del Usuario"> </div>
                    <label>Perfil de Facebook</label><br>
                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                    <input type="text" class="form-control" name="facebook" value="{{$user->user_profile->facebook}}" placeholder="Facebook"> </div>
                    <label>Perfil de Youtube</label><br>
                    <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                    <input type="text" class="form-control" name="youtube" value="{{$user->user_profile->youtube}}" placeholder="Youtube"> </div>
                    <label>Perfil de Instagram</label><br>
                    <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                    <input type="text" class="form-control" name="instagram" value="{{$user->user_profile->instagram}}" placeholder="Instagram"> </div>
                    <label>Perfil de Google Plus</label><br>
                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                    <input type="text" class="form-control" name="googleplus" value="{{$user->user_profile->googleplus}}" placeholder="Google Plus"> </div>
                    <label>Descripcion de Perfil</label><br>
                    <textarea rows="4" cols="50" class="form-control" name="description">{{$user->user_profile->descripcion}}</textarea>
                        <br>
                        <button type="submit" class="btn blue">Actualizar Perfil</button>
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