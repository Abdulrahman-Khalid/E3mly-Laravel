@extends('layouts.app')
@section('content')
    <h1>All of Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="well well-lg">
                <h2><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>
                <form method="GET" action="/profile/{{$post->id}}">                 
                    <input type="hidden" name="post_id" value="{{$post->id}}"/>
                    <input class ="btn btn-info" type="submit" name="Action" value="Show User"/>
                </form>

                <small>posted at {{$post->created_at}}</small>
            </div>
        @endforeach
    @else   
        <p>No posts found</p>
    @endif
@endsection