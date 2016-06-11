@extends('frontend.master_forum')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">La categoría no existe, favor de intentar otro menu</h2>
              <ul class="left">
                <li><a href="#home">FORO</a></li>
                <li>Categoría</li>
              </ul>
            </div>
          </div>
@endsection



@section('main')
<div id="main">
  <div class="forum-block">


              <!-- <h2><span>Otro titulo de la pagina</span></h2> -->
              
              <div class="content-padding">

                <div class="forum-description">
                  <div class="pagination right">
                    <a href="#" class="page-num">1</a>
                    <span class="page-num current">2</span>
                    <a href="#" class="page-num">3</a>
                    <a href="#" class="page-num">4</a>
                    <a href="#" class="page-num">5</a>
                    <span class="page-num page-hidden">...</span>
                    <a href="#" class="page-num">74</a>
                  </div>

                  <a href="{{route('foro.create.view')}}" class="defbutton big"><i class="fa fa-comment-o"></i>CREAR UN NUEVO TEMA</a>
                </div>
              </div>

              <div class="forum-threads-head">
                <strong class="thread-subject"><span>Tema</span></strong>
                <strong class="thread-author">Autor</strong>
                <strong class="thread-replies">Respuestas</strong>
                <strong class="thread-views">Vistas</strong>
                <strong class="thread-last">Última respuesta</strong>
              </div>
              <!-- BEGIN .forum-threads -->
              <div class="forum-threads">
                <h3 align="center" style="color:red;">No existe ninguna categoria con este nombre, así como resultados.</h3>
              <!-- END .forum-threads -->
              </div>
              
              <div class="content-padding">
                <div class="forum-description">
                  <div class="pagination right">
                  
                  </div>

                  <a href="{{route('foro.create.view')}}" class="defbutton big"><i class="fa fa-comment-o"></i>CREAR UN NUEVO TEMA</a>
                </div>
              </div>

            </div>
</div>
@endsection  

@section('sidebar')
  <aside id="sidebar" >
    <div class="panel">
      @include('frontend.widgets.forum.categories')
    </div>
  </aside>
@endsection

 
@section('bottomscripts')

    <style>
      li.comment.fade-transition {
          padding-right: 22px;
      }

      div.comment-content.clearfix {
          margin-left: -100px;
          width: 100%;
      }
      div.user-block {
          padding-right: 10px;
      }

      div.post-text-block {
          padding-left: 5px;
      }
    </style>
@endsection 