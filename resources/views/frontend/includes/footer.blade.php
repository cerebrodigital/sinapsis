<div class="footer">

        <div class="footer-top"></div>
        
        <div class="footer-content">

          <!-- BEGIN .panel -->
          <?php $footer_posts =  \App\models\Post::orderBy('total_views', 'DESC')->orderBy('created_at', 'DESC')->take(3)->get() ?>
          <div class="panel">
            <h2>Artículos Populares</h2>
            <div class="top-right"><a href="#">Ver todo</a></div>
            <div class="panel-content">
              
              <div class="d-articles">
              @foreach($footer_posts as $footer_post)
                <div class="item">
                  <div class="item-header">
                    <a href="{{route('blog.view.post', $footer_post->slug)}}"><img src="{{$footer_post->featured_media}}" alt="" /></a>
                  </div>
                  <div class="item-content">
                    <h4><a href="{{route('blog.view.post', $footer_post->slug)}}">{{ $footer_post->title }}</a></h4>
                    <p>{!! substr(strip_tags($footer_post->body), 0, 55) !!}..</p>
                  </div>
                </div>
              @endforeach
              </div>
              
            </div>
          <!-- END .panel -->
          </div>
            
          <!-- BEGIN .panel -->
          <div class="panel">
            <h2>Más Información</h2>
            <div class="panel-content">
              
              <div>
                <h4>¿Quienes Somos?</h4>
                <p>Somos una comunidad dedicada a la difusión, generación y solución de problematicas de ideas a nivel global.</p>
                <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licencia de Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Cerebro Digital</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="https://cerebrodigital.org" property="cc:attributionName" rel="cc:attributionURL">https://cerebrodigital.org</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Reconocimiento-NoComercial-CompartirIgual 4.0 Internacional License</a>.
      
              </div>
              
            </div>
          <!-- END .panel -->
          </div>
          
          <!-- BEGIN .panel -->
          <div class="panel">
            
              
              @include('frontend.widgets.tag_cloud')
              
            
          <!-- END .panel -->
          </div>

        </div>

        <div class="footer-bottom">
          <div class="left">&copy; Copyright 2016 <strong>Cerebro Digital</strong> - Creative Commons:  <strong>Proyecto Sinapsis</strong></div>
          <div class="right">
            <ul>
              <li><a href="#">Pagina Principal</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">UP</a></li>
              <li><a href="#">Foros</a></li>
            </ul>
          </div>
          <div class="clear-float"></div>
        </div>
        
      <!-- END .footer -->
      </div>