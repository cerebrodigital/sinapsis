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
    <h2>Probando el importador de JSON</h2>
        <div class="portlet-body form">

            <form role="form" method="POST" action="{{route('video.json.import')}}" enctype="multipart/form-data">
                <div class="form-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <textarea rows="10" cols="50"name="jsontext">
                    Aqui pega el JSON
                </textarea>
       

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
                <br>
                <div class="col-md-12">
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Probar</button>
                     
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


@endsection
