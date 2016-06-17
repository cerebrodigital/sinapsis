@extends('backend.master')

@section('breadcrumbs')
<div class="breadcrumbs">
    <h1>Dashboard principal</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <!--
        <li>
            <a href="#">Features</a>
        </li>
        <li class="active">UI Features</li> -->
    </ol>
    <!-- Sidebar Toggle Button -->
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".page-sidebar">
        <span class="sr-only">Toggle navigation</span>
        <span class="toggle-icon">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </span>
    </button>
    <!-- Sidebar Toggle Button -->
</div>
@endsection

@section('content')


<div class="col-md-12 ">
                                        <!-- BEGIN SAMPLE FORM PORTLET-->
    @if($errors)
        {{$errors->first()}}
    @endif
    <h2>CREAR UNA NUEVA PUBLICACIÓN</h2>
        <div class="portlet-body form">

            <form role="form" method="POST" action="{{route('blog.create.new')}}" enctype="multipart/form-data">
                <div class="form-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <?php $user_id = \Auth::user()->id; ?>
                <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <div class="form-group">
                        <label>Titulo de la Nota</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input type="text" class="form-control" name="title" placeholder="Titulo del Post"> </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                </span>
                                <input type="text" class="form-control" name="slug" placeholder="slug-del-post"> </div>
                        </div>

                        
                        <div class="form-group">
                            <label>¿Es una nota destacada? (Marca si si)</label>
                            <input type="checkbox" name="is_featured">
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-tag"></i>
                                </span>
                                <input type="text" class="form-control" name="tags" placeholder="tags separados por coma: ciencia, tecnologia, futuro"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status de la Nota</label>
                            <select class="form-control" name="status">
                            @if(\Gate::denies('admin-access'))
                                <option value="draft">Draft</option>
                                <option value="borrador">Borrador</option>
                            @else
                                <option value="publico">Publicada</option>
                                <option value="draft">Draft</option>
                                <option value="borrador">Borrador</option>
                                <option value="desactivado">Desactivado</option>
                            @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" style=" height: 250px; overflow-y: scroll;">
                        <div class="form-group">
                            <h2>Selecciona las categorías</h2>
                            @foreach($categoriesList as $category)
                                <br>
                                <input type="checkbox" name="categories[]" value="{{$category->id}}"/>
                                <label for="{{$category->id}}" style="color:blue;">{{$category->name}}</label> 
                                @if($category->children)
                                    @foreach($category->children as $child) 
                                                <br>
                                                -> 
                                                <input type="checkbox" name="categories[]" value="{{$child->id}}" id="D0"/>
                                                <label for="D0">  {{$child->name}}</label>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nota completa:</label>
                            <textarea class="form-control" rows="3" name="body" id="summernote"></textarea>
                        </div>

                        
                        <div class="form-group">
                            <label>Tipo de archivo, <b>Puedes elegir subir una imagen y que sea la destacada, o poner URLs de Vimeo, Youtube, Facebook, Instagram, Soundcloud o una URL de imágen externa.</b> Esto puede crear un contenido único usando media de otras redes.</label>
                            <div class="mt-radio-inline">
                                <label class="mt-radio">
                                    <input type="radio"  class="radio-featured" id="imagen_featured" name="type" value="image" checked> Imágen
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio"  class="radio-featured"  id="video_featured" name="type" value="video"> URL de Imagen/Video/Media óAudio
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="featured_imagen">
                            <label for="exampleInputFile1">Imagen destacada de la Nota</label>
                            <input type="file" name="upload_file" id="exampleInputFile1">
                            <input type="hidden" name="featured_media" value="temp" id="hidden_featured">
                            <p class="help-block"> Recuerda subir una imagen de 650x350 o esta va a ser minimizada.</p>
                        </div>
                        <!--
                        <div class="form-group" id="featured_imageURL">
                            <label>URL de Imagen</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-video"></i>
                                </span>
                                <input type="text" class="form-control"  name="featured_image" placeholder="URL de Youtube, Vimeo, Dailymotion, etc."> </div>
                        </div> 
                        -->

                        <div class="form-group" id="featured_video">
                            <label>URL de Video/Media/Audio/Imagen</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-video"></i>
                                </span>
                                <input type="text" class="form-control" name="featured_media" placeholder="URL de Youtube, Vimeo, Dailymotion, Soundcloud, Facebook, etc."> </div>
                        </div>

                        <!--
                        <div class="form-group" id="featured_audio">
                            <label>URL de Audio</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-video"></i>
                                </span>
                                <input type="text" class="form-control" name="featured_media" placeholder="URL de Soundcloud, etc."> </div>
                        </div>
                        -->
                    </div>

                </div>
                <br>
                <div class="col-md-12">
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Agregar Nota</button>
                        <button type="button" class="btn default">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END SAMPLE FORM PORTLET-->
    

    <!-- END SAMPLE FORM PORTLET-->
</div>

@endsection

@section('bottomscripts')
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
              height: 300,                 // set editor height
              minHeight: null,             // set minimum height of editor
              maxHeight: null,             // set maximum height of editor
              focus: true                  // set focus to editable area after initializing summernote
            });
        $("#featured_imagen").show();
        $("#featured_video").hide();
        $("#featured_audio").hide();
        $("#featured_imageURL").hide();
        console.log("Quiero probar que esto este funcionando")

        $('.radio-featured').on('change', function() {
            if ($('#imagen_featured').is(':checked')) {
                $("#featured_imagen").show();
                $("#featured_video").hide();
                $("#featured_audio").hide();
                $("#featured_imageURL").hide();
            } else if($('#video_featured').is(':checked')) {
                $("#featured_imageURL").hide();
                $("#featured_imagen").hide();
                $("#featured_video").show();
                $("#featured_audio").hide();
            } else if($('#imagenURL_featured').is(':checked')) {
                $("#featured_imageURL").hide();
                $("#featured_imagen").hide();
                $("#featured_video").show();
                $("#featured_audio").hide();
            } 

            console.log("WHy whatas asaa");
        });




    });
</script>
@endsection


