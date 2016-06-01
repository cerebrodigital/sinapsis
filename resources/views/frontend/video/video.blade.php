<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$vid->title}}</title>

    <link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
</head>
<body>
<h1>{{$vid->title}}</h1>
    <video id="example_video_1" class="video-js vjs-default-skin vjs-big-play-centered"
           controls preload="auto" height="600" width="980">

        <source src="{{url($vid->media_url)}}" type="video/mp4" />
    </video>
    <p>{{$vid->description}}</p>
    <p><b>Likes: </b> {{$vid->likes}}</p>
    <p><b>Shares: </b> {{$vid->shares}}</p>
    <p><b>Tags: </b> {{$vid->tags}}</p>

    <p><b>Comments:</b></p>


    @if($vid->comments()->count() > 0)
            @foreach($vid->comments()->paginate(15) as $com)
                @if($com->type == 'facebook')
                    <a href="http://facebook.com/{{$com->fb_id}}"><img src="http://graph.facebook.com/{{$com->fb_id}}/picture?type=square"></a>
                @endif
                {{$com->created_at}}: {{$com->name}} - {{$com->message}} <br>
                
            @endforeach
            {!! $vid->comments()->paginate(15)->render() !!}
    @endif  
    <br>
    <b>Otros videos: </b>  <br>
    @foreach($vids as $vid)
      <a href="{{url('video', $vid->id)}}">{{$vid->title}}</a><br>
    @endforeach

    <script src="//vjs.zencdn.net/4.12/video.js"></script>

    <script>
        videojs(document.getElementById('example_video_1'), {}, function() {
            // This is functionally the same as the previous example.
        });
    </script>
</body>
</html>