@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-primary" role="button">Back</a>
    <h1>{{$post->title}}</h1>
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>posted at {{$post->created_at}}</small>

    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
    {!! Form::close() !!}
@endsection