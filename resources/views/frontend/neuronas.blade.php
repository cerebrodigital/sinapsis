@extends('frontend.master_post')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">Usuarios</h2>
              <ul>
                <li><a href="#home">Listado</a></li>
                <li>Neuronas</li>
              </ul>
            </div>
          </div>
@endsection



@section('main')
  
      @section('title')
        Listado de Neuronas | Cerebro Digital
      @endsection
      @section('description')
        Esta es una lista de los últimos usuarios registrados, así como un board de los más activos, más votados y con mayor reputación en la comunidad.
      @endsection
      @section('keywords')
        neuronas, cerebro digita, lista de usuarios, lista de neuronas
      @endsection
      @section('image')
        
      @endsection

    <h2><span>Listado de neuronas/usuarios</span></h2>

            <div class="content-padding">
              <div class="article-full">
                <div class="staff-block">
                <?php 
                  $users = \App\User::orderBy('created_at','DESC')->paginate(15);
                ?>
                @foreach($users as $neurona)
                  <div class="item">
                    <a href="{{route('dashboard.profile', $neurona->id)}}"><img src="http://www.gravatar.com/avatar/{{md5(strtolower(trim($neurona->email)))}}" class="item-photo" alt="" /></a>
                    
                    <div class="item-content">
                    <div class="social-links">
                    @if($neurona->user_profile)
                      @if($neurona->user_profile->facebook)
                        <a href="{{$neurona->user_profile->facebook}}"><i class="fa fa-facebook"></i></a>
                      @endif
                      @if($neurona->user_profile->twitter)
                        <a href="{{$neurona->user_profile->twitter}}"><i class="fa fa-twitter"></i></a>
                      @endif
                      @if($neurona->user_profile->googleplus)
                        <a href="{{$neurona->user_profile->googleplus}}"><i class="fa fa-google-plus"></i></a>
                      @endif
                      @if($neurona->user_profile->youtube)
                        <a href="{{$neurona->user_profile->youtube}}"><i class="fa fa-youtube"></i></a>
                      @endif
                    @endif
                      </div>
                      <h3><a href="{{route('dashboard.profile', $neurona->id)}}">{{$neurona->username}}</a><span>{{$neurona->title}}</span></h3>
                      
                      <p>{{$neurona->name}}</p>
                    @if($neurona->user_profile)
                      <p>{{$neurona->user_profile_descripcion}}</p>
                    @else
                      <p>Esta neurona aún no completa la descripción de su perfil</p>
                    @endif
                    </div>
                  </div>
                @endforeach
                </div>

              </div>
                <br><br><br>
                <div class="clear-list-button" align="center">
                  @if($users->previousPageUrl())
                    <a href="{{$users->previousPageUrl()}}" class="button">Pagina Anterior</a>
                  @endif
                  @if($users->nextPageUrl())
                    <a href="{{$users->nextPageUrl()}}" class="button">Siguiente Pagina</a>
                  @endif
                </div>
            </div>

  <!-- END .content-padding -->

  

@endsection  

@section('sidebar')
          <aside id="sidebar">
            
            <!-- WIDGET READES SOCIALES -->
            @include('frontend.widgets.social')
            
            <!-- WIDGET EVENTO POR VENIR -->
            <!-- WIDGET ULTIMAS PUBLICACIONES -->
            @include('frontend.widgets.latest_posts')

            <!-- WIDGET DUELO DE LA SEMANA -->
            @include('frontend.widgets.weekly_duel')
            
            <!-- WIDGET LOS MAS VISTOS DE LA SEMANA-->
            @include('frontend.widgets.most_viewed')
            
            <!-- WIDGET DONACIONES -->


            
            
            

            
            
            
            <!-- WIDGET INFORMACION DE CONTACTO -->
            

            
          <!-- END #sidebar -->
          </aside>
@endsection   
@section('bottomscripts')
    <script type='text/javascript'>
      var strike_autostart = false;
    </script>
    <style>
      li.comment.fade-transition {
          padding-right: 22px;
      }

      div.comment-content.clearfix {
          margin-left: -100px;
          width: 100%;
      }
      div.social-links a {
          width: 22px;
      }
    </style>
@endsection     