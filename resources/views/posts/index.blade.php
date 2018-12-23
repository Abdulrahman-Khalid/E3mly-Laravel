@extends('layouts.app')
@section('content')


    @if(count($events) > 0)
        @foreach($events as $event) 
             <?php
              $ev = $event->body;
             ?>

            <script>
                alert('{{$ev}}');
            </script>
        @endforeach
    @endif    
    
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="well well-lg">
                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                <small>posted at {{$post->created_at}}</small>
            </div>
        @endforeach
    @else
        <p>No posts found</p>
    @endif
@endsection