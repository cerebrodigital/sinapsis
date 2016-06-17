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


<div class="col-md-4 ">
                                        <!-- BEGIN SAMPLE FORM PORTLET-->
    @if($errors)
        {{$errors->first()}}
    @endif
    @if(!\Gate::denies('admin-access'))
    <h2>CREAR O EDITAR CATEGORIAS DEL FORO</h2>
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Error!</strong> {{Session::get('error')}}.
            </div>
        @endif
    
        <div class="portlet-body form">

            <form role="form" method="POST" action="{{route('foro.categoria.crear')}}">
                <div class="form-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <?php $user_id = \Auth::user()->id; ?>
                <input type="hidden" name="user_id" value="{{ $user_id }}">
                    <div class="form-group">
                    @if($errors->has('name'))
                        {{ $errors->first('name') }}
                    @endif
                        <label>Nombre de la Categoría del Foro</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <input type="text" class="form-control" name="title" placeholder="Titulo de la Categoría"> </div>
                    </div>
                    <div class="form-group">
                    @if($errors->has('slug'))
                        {{ $errors->first('slug') }}
                    @endif
                        <label>Slug</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            <input type="text" class="form-control" name="slug" placeholder="slug-del-post"> 
                        </div>
                    </div>

                    <div class="form-group">
                    @if($errors->has('description'))
                        {{ $errors->first('description') }}
                    @endif
                        <label>Descripción</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                            </span>
                            <textarea type="text" class="form-control" name="description" placeholder="Descripción completa de la categoría"> </textarea>
                        </div>
                    </div>

                    
                    
                    <div class="form-group">
                        <label>Categoría Padre</label>
                        <select name="parent_id" class="form-control">
                            <option value="0" selected disabled style="display:none">choose parent category</option>
                            @foreach ($categoriesList as $category)
                                <option value="{{ $category->id }}" placeholder="choose parent category">{{ $category->title }}</option>
                                @if($category->children)
                                    @foreach ($category->children as $child)
                                        <option value="subcat" placeholder="choose parent category"> - {{ $child->title }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                
                    </div>
                    

                </div>
                <div class="form-actions">
                    <button type="submit" class="btn blue">Agregar Nota</button>
                    <button type="button" class="btn default">Cancelar</button>
                </div>
            </form>
        </div>
    @endif
    </div>
    <!-- END SAMPLE FORM PORTLET-->
    

    <!-- END SAMPLE FORM PORTLET-->
</div>
<div class="col-md-8">
    <div class="portlet-body form">
    @foreach($categories as $item)
            <li>
            <a href="">{{ $item->title }}</a>
            @if($item->children)
                @foreach($item->children as $child)
                 <ul>

                         <li><a href="#">-  {{$child->title}}</a></li>
                 </ul>
                 @endforeach
            @endif
            
           </li>
    @endforeach
    </div>

</div>

@endsection

@section('bottomscripts')
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
<script>
    $(document).ready(function() {
       console.log('Ya cargo');
    });
</script>
@endsection