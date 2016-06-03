<!-- BEGIN .widget -->
<?php 
  $masVistos = \App\models\Video::with('categories')->orderBy('views', 'DESC')->take(5)->get();
?>
<div class="widget">
  <h3>Los Videos más vistos</h3>
  <div class="widget-videos">
  
  @foreach($masVistos as $video)

    <!-- BEGIN .item -->
    <div class="item">
      <div class="item-header">
        <a href="{{route('video.view.one', $video->id)}}" class="video-thumb loadingvideo"><img src="{{$video->featured_image}}" width="150" height="75" class="aspect-px" rel="{{$video->featured_image}}" alt="" /></a>
      </div>
      <div class="item-content">
        <h3><a href="{{route('video.view.one', $video->id)}}">{{$video->title}}</a><a href="#"><span class="marker">@foreach($video->categories()->get() as $category){{$category->name}}, @endforeach</span></a></h3>
        <span class="video-meta">
          <a href="{{route('video.view.one', $video->id)}}"><i class="fa fa-comment"></i>{{ \App\models\VideoComment::where('video_id', '=', $video->id)->count()}}</a>
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