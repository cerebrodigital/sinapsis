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
                    <!-- BEGIN DASHBOARD STATS 1-->
                    @include('backend.includes.widgets.dashboardstats')
                    <!-- END DASHBOARD STATS 1-->


                    <div class="row">
                        @include('backend.includes.widgets.comentarios')
                        
                        @include('backend.includes.widgets.acciones')
                    </div>
                    
                    <div class="row">
                        @include('backend.includes.widgets.actividades')
                        @include('backend.includes.widgets.feeds')

                    </div>

@endsection



