<?php 
  $masVistos = \App\models\Video::with('categories')->orderBy('likes', 'DESC')->take(5)->get();
?>
<!-- BEGIN .widget -->
<div class="widget">
  <h3>Los Videos más Gustados</h3>
  <div class="widget-videos-small">
  @foreach($masVistos as $video)
    <!-- BEGIN .item -->
    <div class="item">
      <div class="item-header">
        <a href="{{route('video.view.one', $video->id)}}" class="video-thumb loadingvideo"><img src="{{$video->featured_image}}" width="50" height="50" class="aspect-px" rel="{{$video->featured_image}}" alt="" /></a>
      </div>
      <div class="item-content">
        <a href="post.html"><span class="marker">@foreach($video->categories()->get() as $category){{$category->name}}, @endforeach</span></a>
        <h6><a href="{{route('video.view.one', $video->id)}}">{!! substr(strip_tags($video->title), 0, 53) !!}...</a></h6>
        <span class="video-meta">
          <a href="{{route('video.view.one', $video->id)}}"><i class="fa fa-comment"></i>{{ \App\Models\VideoComment::where('video_id', '=', $video->id)->count()}}</a>
          <a href="{{route('video.view.one', $video->id)}}"><i class="fa fa-eye"></i>{{$video->views}}</a>
          <a href="#"><i class="fa fa-heart"></i>{{$video->likes}}</a>
        </span>
      </div>
    <!-- END .item -->
    </div>
  @endforeach
  

  </div>
<!-- END .widget -->
</div>