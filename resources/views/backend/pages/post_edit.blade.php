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
        <span class="sr-only">Editar publicacion</span>
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
    @if(\Session::has('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error!</strong> No se pudo actualizar la publicación
    </div>
    @endif
    @if(\Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Se guardo satisfactoriamente!</strong> La publicación fue guardada correctamente.. Verificar.
    </div>
    @endif

    @foreach($post as $var)
    <h2>EDITAR PUBLICACIÓN</h2>
        <div class="portlet-body form">

            <form role="form" method="POST" action="{{route('blog.post.update', $var->id)}}">
                <div class="form-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <?php $user_id = \Auth::user()->id; ?>
                <input type="hidden" name="user_id" value="{{ $user_id }}">
                <input type="hidden" name="id" value="{{ $var->id }}">
                    <div class="form-group">
                        <label>Titulo de la Nota</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input type="text" class="form-control" name="title" placeholder="Titulo del Post" value="{{$var->title}}"> </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                </span>
                                <input type="text" class="form-control" name="slug" placeholder="slug-del-post" value="{{$var->slug}}"> </div>
                        </div>

                        
                        <div class="form-group">
                            <label>¿Es una nota destacada? (Marca si si)</label>
                            <input type="checkbox" name="is_featured" value="{{$var->is_featured}}">
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-tag"></i>
                                </span>
                                <input type="text" class="form-control" name="tags" placeholder="tags separados por coma: ciencia, tecnologia, futuro" value="{{$var->tags}}"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status de la Nota</label>
                            <select class="form-control" name="status" >
                                <option value="draft" @if($var->status == "draft") selected @endif>Draft</option>
                                <option value="publicada" @if($var->status == "publicada") selected @endif>Publicada</option>
                                <option value="revision" @if($var->status == "revision") selected @endif>Revisión</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" style=" height: 250px; overflow-y: scroll;">
                        <div class="form-group">
                            <h2>Selecciona las categorías</h2>
                            <?php 
                                $selected_categories = \DB::table('post_categories')->where('post_id', $var->id)->get();
                            ?>
                            @foreach($categoriesList as $category)
                                <br>
                                <input type="checkbox" name="categories[]" value="{{$category->id}}" 
                                    @foreach($selected_categories as $cat)   
                                        @if($cat->category_id == $category->id)
                                            checked 
                                        @endif
                                    @endforeach
                                    />
                                <label for="{{$category->id}}" style="color:blue;">{{$category->name}}</label> 
                                @if($category->children)
                                    @foreach($category->children as $child) 
                                                <br>
                                                -> 
                                                <input type="checkbox" name="categories[]" value="{{$child->id}}" id="D0" 
                                                    @foreach($selected_categories as $cat)   
                                                        @if($cat->category_id == $child->id)
                                                            checked 
                                                        @endif
                                                    @endforeach
                                                />
                                                <label for="D0">  {{$child->name}}</label>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nota completa:</label>
                            <textarea class="form-control" rows="3" name="body" id="summernote">{!!$var->body!!}</textarea>
                        </div>

                        
                        <div class="form-group">
                            <label>Tipo de archivo destacado</label>
                            <div class="mt-radio-inline">
                                <label class="mt-radio">
                                    <input type="radio"  class="radio-featured" id="imagen_featured" name="type" value="image" @if($var->type == "image") checked @endif> Imágen
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio"  class="radio-featured"  id="imagenURL_featured" name="type" value="URLimage" @if($var->type == "URLimage") checked @endif> URL Imagen
                                    <span></span>
                                </label>
                                <label class="mt-radio">
                                    <input type="radio"  class="radio-featured"  id="video_featured" name="type" value="video" @if($var->type == "video") checked @endif> Video
                                    <span></span>
                                </label>
                                <label  class="mt-radio">
                                    <input type="radio" class="radio-featured"  id="audio_featured" name="type" value="audio" @if($var->type == "audio") checked @endif> Audio
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        
                            <div class="form-group" id="featured_imagen">
                                <label for="exampleInputFile1">Imagen destacada de la Nota</label>
                                @if($var->type == 'image')
                                    <div class="col-md-3 thumbnail"><img src="{{$var->featured_media}}" height="100"></div>
                                @endif
                                <input type="file" name="upload_file" id="exampleInputFile1" >
                                <input type="hidden" name="featured_media" value="temp" id="hidden_featured">
                                <p class="help-block"> Tu imagén será automaticamente cambiada a 800 pixeles de ancho.</p>
                            </div>
                       
                        
                        
                            <div class="form-group" id="featured_imageURL">
                                <label>URL de Imagen</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-video"></i>
                                    </span>
                                    <input type="text" class="form-control"  name="featured_media" placeholder="URL de Youtube, Vimeo, Dailymotion, etc." value="{{$var->featured_media}}"> </div>
                            </div>
                        

                            <div class="form-group" id="featured_video">
                                <label>URL de Video</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-video"></i>
                                    </span>
                                    <input type="text" class="form-control" name="featured_media" placeholder="URL de Youtube, Vimeo, Dailymotion, etc." value="{{$var->featured_media}}"> </div>
                            </div>
                        
                        
                            <div class="form-group" id="featured_audio">
                                <label>URL de Audio</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-video"></i>
                                    </span>
                                    <input type="text" class="form-control" name="featured_media" placeholder="URL de Soundcloud, etc." value="{{$var->featured_media}}"> </div>
                            </div>
                        
                    </div>

                </div>
                <br>
                <div class="col-md-12">
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Actualizar Nota</button>
                        
                    </div>
                </div>




            </form>
        </div>
    </div>
    @endforeach
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
        @foreach($post as $var)
            @if($var->type == 'image')
                $("#featured_image").show();
                $("#featured_video").hide();
                $("#featured_audio").hide();
                $("#featured_imageURL").hide();
            @endif    
            @if($var->type == 'imageURL')
                $("#featured_imageURL").show();
                $("#featured_video").hide();
                $("#featured_audio").hide();
                $("#featured_image").hide();
            @endif
            @if($var->type == 'video')
                $("#featured_imageURL").hide();
                $("#featured_video").show();
                $("#featured_audio").hide();
                $("#featured_image").hide();
            @endif
            @if($var->type == 'audio')
                $("#featured_imageURL").hide();
                $("#featured_video").hide();
                $("#featured_audio").show();
                $("#featured_image").hide();
            @endif
        @endforeach

        console.log("Quiero probar que esto este funcionando")

        $('.radio-featured').on('change', function() {
            if ($('#imagen_featured').is(':checked')) {
                $("#featured_imagen").show();
                $("#featured_video").hide();
                $("#featured_audio").hide();
                $("#featured_imageURL").hide();
            } else if($('#imagenURL_featured').is(':checked')) {
                $("#featured_imageURL").show();
                $("#featured_imagen").hide();
                $("#featured_video").hide();
                $("#featured_audio").hide();
            } else if($('#video_featured').is(':checked')) {
                $("#featured_imageURL").hide();
                $("#featured_imagen").hide();
                $("#featured_video").show();
                $("#featured_audio").hide();
            } else {
                $("#featured_imageURL").hide();
                $("#featured_imagen").hide();
                $("#featured_video").hide();
                $("#featured_audio").show();
            }
            console.log("WHy whatas asaa");
        });


    });
</script>
@endsection