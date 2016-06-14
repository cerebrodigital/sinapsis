<?php $mostViewed_posts = App\models\Post::orderBy('total_views', 'DESC')->orderBy('created_at', 'DESC')->take(7)->get(); ?>
<div class="panel">
  <h2>Más Vistos de la Semana</h2>
  <div class="top-right"><a href="blog.html">Ver todos</a></div>
  <div class="panel-content">
    
    <div class="d-articles">
      @foreach($mostViewed_posts as $post)
      <div class="item">
        <div class="item-header">
          <a href="{{route('blog.view.post', $post->slug)}}"><img src="{{$post->featured_media}}" alt="" /></a>
        </div>
        <div class="item-content">
          <h4><a href="{{route('blog.view.post', $post->slug)}}">{{$post->title}}</a></h4>
          <p>{!! substr(strip_tags($post->body), 0, 90) !!}...</p>
        </div>
      </div>
      @endforeach
    </div>
    
  </div>
<!-- END .panel -->
</div>