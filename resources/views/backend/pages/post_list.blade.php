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

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">LISTADO DE TODAS LAS PUBLICACIONES</span>
                </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" width="100%" id="sample_1">
                    <thead>
                        <tr>
                            <th class="all">id</th>
                            <th class="min-phone-l">UID</th>
                            <th class="min-tablet" width="20%">Titulo</th>
                            <th class="none">Media Destacado</th>
                            <th class="none">Vistas totales</th>
                            <th class="none">Status</th>
                            <th class="desktop">Slug</th>
                            <th class="none">Creado en:</th>
                            <th class="none">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->user_id}}</td>
                            <td>{{$post->title}}</td>
                            @if($post->type == 'image' || 'URLimage')
                                <td><img src="{{$post->featured_media}}" class="thumbnail" height="45"></td>
                            @else
                                <td>{{$post->featured_media}}</td>
                            @endif
                            <td>{{$post->total_views}}</td>
                            <td>{{$post->status}}</td>
                            <td>{{$post->slug}}</td>
                            <td>{{$post->created_at}}</td>
                            <td><a href="{{route('blog.post.edit', array('id' => $post->id))}}" class="btn -small-warning">EDITAR</a>
                                @if(\Auth::user()->is_admin)
                                    <a href="{{route('blog.post.delete', array('id' => $post->id))}}" class="btn btn-warning">BORRAR</a>
                                    <a href="{{route('blog.post.deletePermanent', array('id' => $post->id))}}" class="btn btn-danger">borrar permanentemente</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach    
                    </tbody>
                </table>
            </div>
            {!! $posts->render() !!}
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    
</div>
@endsection

@section('bottomscripts')

@endsection
