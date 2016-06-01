@extends('comments::admin.layout')

@section('title') Settings @stop

@section('content')
    <comments-settings inline-template>
        <ul class="nav nav-tabs">
            <li :class="{disabled: loading}" class="active"><a href="#general" data-toggle="tab">General</a></li>
            <li :Class="{disabled: loading}"><a href="#formatting" data-toggle="tab">Formatting</a></li>
            <li :class="{disabled: loading}"><a href="#moderation" data-toggle="tab">Moderation</a></li>
            <li :class="{disabled: loading}"><a href="#protection" data-toggle="tab">Protection</a></li>
            <li :class="{disabled: loading}"><a href="#notifications" data-toggle="tab">Notifications</a></li>
        </ul>

        <div class="tab-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="tab-content">
                        <div class="tab-pane active" id="general">
                            @include('comments::admin.partials.general')
                        </div>
                        <div class="tab-pane" id="formatting">
                            @include('comments::admin.partials.formatting')
                        </div>
                        <div class="tab-pane" id="moderation">
                            @include('comments::admin.partials.moderation')
                        </div>
                        <div class="tab-pane" id="protection">
                            @include('comments::admin.partials.protection')
                        </div>
                        <div class="tab-pane" id="notifications">
                            @include('comments::admin.partials.notifications')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </comments-settings>

    <style>
        .tab-pane { margin-top: 15px; }
        .page-header { display:  none; }
    </style>
@stop
