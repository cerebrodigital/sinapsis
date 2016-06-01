<div class="navbar navbar-top navbar-fixed-top">
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand">Home</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="{{ Route::is('comments.admin.index') ? 'active' : '' }}">
                        <a href="{{ route('comments.admin.index') }}">
                            <span class="glyphicon glyphicon-comment"></span> Dashboard
                        </a>
                    </li>
                    <li class="{{ Route::is('comments.admin.settings') ? 'active' : '' }}">
                        <a href="{{ route('comments.admin.settings') }}">
                            <span class="glyphicon glyphicon-cog"></span> Settings
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/auth/logout">
                        <span class="glyphicon glyphicon-log-out"></span> Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
