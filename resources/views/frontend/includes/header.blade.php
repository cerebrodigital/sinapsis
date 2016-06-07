<header id="header">
          <div id="menu-bottom">
            <!-- <nav id="menu" class="main-menu width-fluid"> -->
            <nav id="menu" class="main-menu">
              <div class="blur-before"></div>
              <a href="{{route('landing')}}" class="header-logo left"><img src="/syn/images/logo.png" class="logo" alt="Revelio" title="" /></a>
              <a href="#dat-menu" class="datmenu-prompt"><i class="fa fa-bars"></i>Show menu</a>
              <ul class="load-responsive" rel="Main menu">
                <li><a href="#"><span><i class="fa fa-comment"></i><strong>Noticias</strong></span></a>
                  <ul class="sub-menu">
                      <?php $categoriesList = \App\models\Category::with('children')->where('parent_id', '0')->get(); ?>
                      @foreach($categoriesList as $category)
                        <br>
                        <li><a href="{{route('blog.view.category', $category->slug)}}">{{$category->name}}</a>
                        @if($category->children)
                          <ul class="sub-menu">
                            @foreach($category->children as $child) 
                                <li><a href="{{route('blog.view.category', $child->slug)}}">{{$child->name}}</a></li>
                            @endforeach
                          </ul>
                        @endif
                        </li>
                      @endforeach
                  </ul>
                </li>
                <li><a href="{{route('video.view.categorias')}}"><span><i class="fa fa-camera-retro"></i><strong>Videos</strong></span></a>
                  <ul class="sub-menu">
                      <?php $categoriesList = \App\models\Category::with('children')->where('parent_id', '0')->get(); ?>
                      @foreach($categoriesList as $category)
                        <br>
                        <li><a href="{{route('video.view.category', $category->slug)}}">{{$category->name}}</a>
                            <ul class="sub-menu">
                        @if($category->children)
                          
                            @foreach($category->children as $child) 
                                <li><a href="{{route('video.view.category', $child->slug)}}">{{$child->name}}</a></li>
                            @endforeach
                          
                        @endif
                            </ul>
                        </li>
                      @endforeach
                  </ul>
                </li>
                
                <li><a href="#quests"><span><i class="fa fa-puzzle-piece"></i><strong>Quests</strong></span></a>
                  <!--
                  <ul class="sub-menu">
                    <li><a href="shortcodes.html">Shortcodes</a></li>
                    <li><a href="login.html">Login page</a></li>
                    <li><a href="signup.html">Sign up page</a></li>
                    <li><a href="messages.html">Private messages</a></li>
                    <li><a href="games-single.html">Games detail page</a></li>
                    <li><a href="podcasts.html">Podcast list</a></li>
                    <li><a href="podcasts-single.html">Podcast single</a></li>
                    <li><a href="404-page.html">404 Page</a></li>
                  </ul> -->
                </li>
                
                <li><a href="#up"><i class="fa fa-camera-retro"></i><strong>UP</strong></a></li>
                <li><a href="#forum"><span><i class="fa fa-comments-o"></i><strong>Foro</strong></span></a>
                  <!--
                  <ul class="sub-menu">
                    <li><a href="#">Lista de Ultimas Publicaciones</a></li>
                    <li><a href="#">Single forum topic</a></li>
                    <li><a href="#">Crear una nueva publicación</a></li>
                  </ul>
                  -->
                </li>
                <li><a href="#neuronas"><span><i class="fa fa-users"></i><strong>Neuronas</strong></span></a>
                  <!--
                  <ul class="sub-menu">
                    <li><a href="#">Miembros</a></li>
                    <li><a href="user-single.html">Member profile</a></li>
                    <li><a href="user-single-blog.html">Members personal blog</a></li>
                    <li><a href="user-single-guestbook.html">Member guest book</a></li>
                    <li><a href="user-single-friends.html">Member friends list</a></li>
                    <li><a href="user-single-instagram.html">Member Instagram photos</a></li>
                  </ul>
                  -->
                </li>
                <li><a href="#contacto"><i class="fa fa-map-marker"></i><strong>Contacto</strong></a></li>
                <!-- <li class="no-icon"><a href="#"><strong>Without icon</strong></a></li> -->
              </ul>
            </nav>
          </div>


          @yield('breadcrumbs')
          
        </header>