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
<!--
Why this?
this to show individual posts and have a chance to report them
yet, different users arent able to report each users
?php $post_id = (int)$post[0]->id ?>

-->
    
      <form method="GET" action="/feedback/create">
        <input type="hidden" name="post_id" value="{{$post[0]->id}}"/>
        <input class ="btn btn-warning" type="submit" name="Action" value="Report"/>
      </form>
       

@endsection