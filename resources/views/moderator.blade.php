@extends('layouts.app')
@section('content')
    <h1>All of Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="well well-lg">
                <h2><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>
                <h5>Created By: <a href="/profile/{{$post->user_id}}">{{$post->user_name}}</a></h5>
                <small>posted at {{$post->created_at}}</small>
            </div>
        @endforeach
    @else   
        <p>No posts found</p>
    @endif
@endsection