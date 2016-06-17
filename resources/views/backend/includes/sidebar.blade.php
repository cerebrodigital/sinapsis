<div class="page-sidebar">
                                <nav class="navbar" role="navigation">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <h3>Posts</h3>
                                    <ul class="nav navbar-nav margin-bottom-35">
                                        <li>
                                            <a href="{{route('blog.post.list')}}">
                                                <i class="icon-user"></i> Todas las publicaciones ({{\App\models\Post::all()->count()}})</a>
                                        </li>
                                        <li>
                                            <a href="{{route('blog.post.public')}}">
                                                <i class="icon-home"></i> Posts Públicos ({{\App\models\Post::where('status', 'publico')->count()}})</a>
                                        </li>
                                        <li>
                                            <a href="{{route('blog.post.draft')}}">
                                                <i class="icon-note "></i> Posts en Draft ({{\App\models\Post::where('status', 'draft')->count()}})</a>
                                        </li>
                                        <li>
                                            <a href="{{route('blog.post.trash')}}">
                                                <i class="icon-trash "></i> Basura ({{\App\models\Post::where('status', 'trash')->count()}})</a>
                                        </li>
                                    </ul>
                                    <h3>Videos</h3>
                                    <ul class="nav navbar-nav margin-bottom-35">
                                        <li>
                                            <a href="{{route('videos.post.list')}}">
                                                <i class="icon-user"></i> Todos los Videos ({{\App\models\Video::all()->count()}})</a>
                                        </li>
                                    </ul>
                                    <!--
                                    <h3>Quick Actions</h3>
                                    <ul class="nav navbar-nav">
                                        <li>
                                            <a href="#">
                                                <i class="icon-envelope "></i> Inbox
                                                <label class="label label-danger">New</label>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-paper-clip "></i> Task </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-star"></i> Projects </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-pin"></i> Events
                                                <span class="badge badge-success">2</span>
                                            </a>
                                        </li>
                                    </ul>
                                    -->
                                </nav>
                            </div>