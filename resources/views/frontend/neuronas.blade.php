@extends('frontend.master_post')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">Blog</h2>
              <ul>
                <li><a href="#home">Noticia</a></li>
                <li>Categoria</li>
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
  <h2><span>Listado de Neuronas</span></h2>
  <div class="content-padding">

    <div class="article-full">
      <div class="article-main-photo">
        <p>Esta es una lista de los últimos usuarios registrados, así como un board de los más activos, más votados y con mayor reputación en la comunidad.</p>
      </div>
      <div class="article-icons">

      </div>
      <!-- ESTA ES PARA ORG <div class='shareaholic-canvas' data-app='share_buttons' data-app-id='24569125'></div> -->

      <div class="friends-block">
          <?php 
            $users = \App\User::orderBy('created_at','DESC')->get();
          ?>
          @foreach($users as $neurona)
                <div class="friend-single">
                      <a href="user-single.html" class="avatar online"><img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($neurona->email))); ?>" class="setborder" title="" alt="" /></a>
                      <a href="user-single.html" class="friend-user user-tooltip"><b>{{$neurona->name}}</b></a>
                      <a href="user-single.html" class="friend-user user-tooltip"><b>{{$neurona->username}}</b></a>
                </div>
          @endforeach
      </div>
      <div>
      
      </div>
      <br>
    </div>
    
    <!-- <div class="clear-float do-the-split"></div> -->
    
    <!-- BEGIN .article-footer -->
    <div class="article-footer">


      <div class="similar-posts">
        
        
          
        </div>

      </div>
    <!-- END .article-footer -->
    </div>

  <!-- END .content-padding -->
  </div>
  <!-- HERE I ATTACH THE INCLUDE -->


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
    <link rel="stylesheet" href="/vendor/comments/css/bootstrapless.css">
    <link rel="stylesheet" href="/vendor/comments/css/prism-okaidia.css"> <!-- Optional -->

    <!-- Must be included before the closing </body> tag! -->

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
  </style>
@endsection   