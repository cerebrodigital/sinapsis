<div id="header-top">
        <div class="wrapper">
          <ul class="right">
            <li><a href="http://facebook.com/tucerebrodigital" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="http://twitter.com/digitalcerebro" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://www.youtube.com/channel/UC0tpy9WTnTzc4H4Dti6V-1Q" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
            <li><a href="http://cerebrodigital.tumblr.com" target="_blank"><i class="fa fa-tumblr"></i></a></li>
            <li><a href="http://instagram.com/tucerebrodigital" target="_blank"><i class="fa fa-instagram"></i></a></li>
            <li><a href="http://pinterest.com/digitalcerebro" target="_blank"><i class="fa fa-pinterest"></i></a></li>
            <li><a href="https://plus.google.com/+CerebrodigitalOrg" target="_blank"><i class="fa fa-google"></i></a></li>
          
          </ul>
          <ul class="load-responsive" rel="Top menu">
            <li><a href="podcasts.html">Podcasts</a></li>
            <li><a href="messages.html"><span>Private messages</span></a>
              <ul class="sub-menu">
                <li><a href="messages.html">Conversation list</a></li>
                <li><a href="messages-conversation.html">Single conversation</a></li>
                <li><a href="messages-write.html">Start new conversation</a></li>
              </ul>
            </li>
            @if(Auth::check())
              @include('frontend.includes.readlater')
              <li><a href="{{route('sinapsis.logout')}}" style="color:red;">Desconectar</a></li>
              @if(\Auth::user()->is_admin == true)
                <li><a href="{{route('backend.home')}}" style="color:#f4378c;">Admin Deck</a></li>
              @endif
            @endif
            @if(!Auth::check())
              <li><a href="{{url('login')}}">Conectarse</a></li>
              <li><a href="{{url('register')}}">Registrarse</a></li>
            @endif
            <li><a href="#">Actividad</a></li>

          </ul>
        </div>
      </div>