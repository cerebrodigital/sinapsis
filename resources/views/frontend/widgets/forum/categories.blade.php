<?php
  $categories = \App\models\ForumCategory::with('children')->where('parent_id', '0')->get();
?>

    <p align="center">Menu del Foro</p>
    <div class="the-profile-top">
    @foreach($categories as $item)
            
            <a href="{{route('foro.topic.category', $item->id)}}"  class="defbutton profile-button" style="font-size:14px;">{{ $item->title }} ({{$item->topics->count()}})</a>
            @if($item->children)
                @foreach($item->children as $child)
                 
                         <a href="{{route('foro.topic.category', $child->id)}}"class="defbutton profile-button" style="font-size:10px;">{{$child->title}} ({{$child->topics->count()}}) </a>
                 
                 @endforeach
            @endif
            
           
    @endforeach
    </div>
