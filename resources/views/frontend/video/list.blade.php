<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$vids->first()->title}}</title>

    <link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
</head>
<body>
@foreach($vids as $vid)
  <a href="{{url('video', $vid->id)}}">{{$vid->title}}</a><br>
@endforeach
<h1>{{$vids->first()->title}}</h1>
    <video id="example_video_1" class="video-js vjs-default-skin vjs-big-play-centered"
           controls preload="auto" height="300" width="300">

        <source src="{{url($vid->media_url)}}" type="video/mp4" />
    </video>
    <p>{{$vid->first()->description}}</p>
    <p><b>Likes: </b> {{$vid->first()->likes}}</p>
    <p><b>Shares: </b> {{$vid->first()->shares}}</p>
    <p><b>Tags: </b> {{$vid->first()->tags}}</p>

    <script src="//vjs.zencdn.net/4.12/video.js"></script>

    <script>
        videojs(document.getElementById('example_video_1'), {}, function() {
            // This is functionally the same as the previous example.
        });
    </script>
</body>
</html>