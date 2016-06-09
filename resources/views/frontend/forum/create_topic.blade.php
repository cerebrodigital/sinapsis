@extends('frontend.master_forum')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right"><u>Agregar un Nuevo Tema al FORO</u></h2>
              <ul class="left">
                <li><a href="#home">FORO</a></li>
                <li>Topic</li>
              </ul>
            </div>
          </div>
@endsection



@section('main')
<div id="main">
  <div class="forum-block">

  <a href="{{route('foro.topic.all')}}" class="defbutton big"><i class="fa fa-arrow-left"></i>CANCELAR Y REGRESAR A VER TODOS LOS TEMAS</a>
    @if($errors)
        <h3 style="color:red;">{{$errors->first()}}</h3>
    @endif
    @if(!\Auth::check())
        <h4>Necesitas estar conectado para poder publicar un Tema</h4>
        <a href="{{url('/login')}}"><button type="submit" align="center" class="btn blue" style="font-size:17px;">CONECTAR</button></a>

    @else
      <div id="response-message">
        <form role="form" method="POST" action="{{route('foro.create.post')}}" enctype="multipart/form-data">
          <p>Hola {{\Auth::user()->name}} ¿Estas listo para crear un Tema en el Foro?</p>
          <label for="title">Titulo del Tema:</label><br>
          <input type="text" name="title" size="80" value="">
          <br>

          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <label for="title">Mensaje completo con media y links:</label><br>
          <textarea name="message" id="message" style="height:300px;width:100%;"></textarea>
          <br>
          <div class="form-group">
              <label>Categoría del Tema(*):</label><br>
              <select name="parent_id" class="form-control">
                  <option value="0" selected disabled style="display:none">Por favor selecciona una categoría</option>
                  @foreach ($categoriesList as $category)
                      <option value="{{ $category->id }}" placeholder="choose parent category">{{ $category->title }}</option>
                      @if($category->children)
                          @foreach ($category->children as $child)
                              <option value="subcat" placeholder="choose parent category"> - {{ $child->title }}</option>
                          @endforeach
                      @endif
                  @endforeach
              </select>
      
          </div><br>
          <label for="tags">Tags del Tema:</label><br>
          <input type="text" name="tags" value="">
          <div class="respond-submit">
            <a href="{{route('foro.topic.all')}}" class="defbutton big"><i class="fa fa-arrow-left"></i>CANCELAR Y REGRESAR A VER TODOS LOS TEMAS</a>
            <button type="submit" align="center" class="defbutton big" style="font-size:17px;">PUBLICAR RESPUESTA</button>
          </div>
         </form>
      </div>
    @endif

  </div>
               
</div>

@endsection  

@section('sidebar')
  <aside id="sidebar" >
    <div class="panel">
      <h4>Por favor procura tomar en cuenta las siguientes reglas:</h4>
      <ul>
        <li>No crear publicidad de ningún producto sin relación.</li>
        <li>No insultar, este foro esta destinado para hacer sinapsis no para perderla.</li>
        <li>Recuerda que lo que contestes puede conllevar a puntos negativos en tu reputación.</li>
        <li>Procurar no tratar temas de Sexo, Política y Religión, solo en las categorias permitidas.</li>
      </ul>
    </div>
  </aside>
@endsection

 
@section('bottomscripts')
    <link rel="stylesheet" href="/vendor/comments/css/bootstrapless.css">
    <link rel="stylesheet" href="/vendor/comments/css/prism-okaidia.css"> <!-- Optional -->
    <link rel="stylesheet" href="/vendor/comments/css/comments.css">
    <script src="//cdn.jsdelivr.net/vue/1.0.16/vue.min.js"></script>

    <!-- Must be included before the closing </body> tag! -->
    <script src="/vendor/comments/js/utils.js"></script> 
    <script src="/vendor/comments/js/comments.js"></script>
    <script>new Vue({el: '#comments'});</script>
    <script type='text/javascript'>
      var strike_autostart = false;

      $(document).ready(function() {
        var initEditor = function() {
          $("#message").sceditor({
            plugins: 'bbcode',
            style: "/foro/minified/jquery.sceditor.modern.min.css"
          });
        };
        initEditor();
      });

    </script>
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