<div class="content-panel">
<?php 
$similars = \App\models\VideoCategory::where('category_id', '=', $categoria_id)->with('videos')->take(6)->get();

?>
              <div class="panel-title">
                <h2>Videos Similares</h2>
                <div class="right video-set-layout">
                  <a href="#v-set-layout" rel="grid" class="active"><i class="fa fa-th"></i></a>
                  <a href="#v-set-layout" rel="hdgrid"><i class="fa fa-th-large"></i></a>
                  <a href="#v-set-layout" rel="list"><i class="fa fa-th-list"></i></a>
                  <a href="#v-set-layout" rel="hdlist"><i class="fa fa-bars"></i></a>
                </div>
              </div>
              <div class="panel-block video-list grid">
              @foreach($similars as $video)
                @foreach($video->videos as $similar)
                <!-- BEGIN .item -->
                <div class="item">
                  <div class="item-header">
                    <a href="{{route('video.view.one', $similar->id)}}" class="img-hover-effect loadingvideo"><img src="{{$similar->featured_image}}" width="16" height="9" class="aspect-px" rel="{{$similar->featured_image}}" alt="" /></a>
                  </div>
                  <div class="item-content">
                    <h3><a href="{{route('video.view.one', $similar->id)}}">{{$similar->title}}</a></h3>
                    <span class="video-meta">
                      <a href="{{route('video.view.one', $similar->id)}}"><i class="fa fa-comment"></i>283</a>
                      <a href="{{route('video.view.one', $similar->id)}}"><i class="fa fa-eye"></i>{{$similar->views}}</a>
                      <a href="{{route('video.view.one', $similar->id)}}"><i class="fa fa-heart"></i>{{$similar->likes}}</a>
                    </span>
                  </div>
                <!-- END .item -->
                </div>
                @endforeach
              @endforeach



       

              </div>
            </div>
            </div>