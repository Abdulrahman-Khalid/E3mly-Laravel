@extends('layouts.app')

@section('content')


    @if(Auth::guard('web')->check())
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

        
          <form method="GET" action="/feedback/create">
            <input type="hidden" name="post_id" value="{{$post[0]->id}}"/>
            <input class ="btn btn-warning" type="submit" name="Action" value="Report"/>
          </form>
    @endif
    @if(Auth::guard('moderator')->check())
        <a href="/feedback" class="btn btn-primary" role="button">Back</a>
        <h1>{{$post[0]->title}}</h1>
        
        <div>
            {!!$post[0]->body!!}
        </div>
        <hr>
        <small>posted at {{$post[0]->created_at}}</small>

        {!! Form::open(['action' => ['PostsController@destroy', $post[0]->id], 'method' => 'POST']) !!}
            {{Form::hidden('_method','DELETE')}}
            {{Form::submit('Delete the Post', ['class'=> 'btn btn-danger'])}}
        {!! Form::close() !!}

        
    @endif
@endsection