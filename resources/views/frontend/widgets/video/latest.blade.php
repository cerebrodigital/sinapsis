<div class="content-panel">
  <div class="panel-title">
    <h2>Latest Videos</h2>
    <div class="right video-set-layout">
      <a href="#v-set-layout" rel="grid" class="active"><i class="fa fa-th"></i></a>
      <a href="#v-set-layout" rel="hdgrid"><i class="fa fa-th-large"></i></a>
      <a href="#v-set-layout" rel="list"><i class="fa fa-th-list"></i></a>
      <a href="#v-set-layout" rel="hdlist"><i class="fa fa-bars"></i></a>
    </div>
  </div>
  <div class="panel-block video-list grid">
  
    <?php
    $videos = \App\models\Video::orderBy('updated_at', 'DESC')->take(6)->get();
    ?>
    @foreach($videos as $vid)
    <!-- BEGIN .item -->
    <div class="item">
      <div class="item-header">
        <a href="{{route('video.view.one', $vid->id)}}" class="img-hover-effect loadingvideo"><img src="{{$vid->featured_image}}" width="56" height="34" class="aspect-px" /></a>
      </div>
      <div class="item-content">
        <h3><a href="{{route('video.view.one', $vid->id)}}">{{$vid->title}}</a></h3>
        <span class="video-meta">
          <a href="post.html"><i class="fa fa-comment"></i>283</a>
          <a href="post.html"><i class="fa fa-eye"></i>{{$vid->views}}</a>
          <a href="#"><i class="fa fa-heart"></i>{{$vid->likes}}</a>
        </span>
        <p>{{$vid->title}}</p>
      </div>
    <!-- END .item -->
    </div>
    @endforeach

   

    <div class="clear-list-button">
      <a href="{{route('video.view.categorias')}}" class="back-button">Ver más videos</a>
    </div>

  </div>
</div>