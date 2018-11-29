@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-primary" role="button">Back</a>
    <h1>{{$post[0]->title}}</h1>
    <div>
        {!!$post[0]->body!!}
    </div>
    <hr>
    <small>posted at {{$post[0]->created_at}}</small>

    {!! Form::open(['action' => ['PostsController@destroy', $post[0]->id], 'method' => 'POST']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
    {!! Form::close() !!}
@endsection