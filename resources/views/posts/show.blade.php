@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-primary" role="button">Back</a>
    <h1>{{$post[0]->title}}</h1>
    <div>
        {!!$post[0]->body!!}
    </div>
    <hr>
    <small>posted at {{$post[0]->created_at}}</small>
    <div class="container">
        <div class="row"> 
            <div class="col-md-auto">
                <form method="GET" action="/proposals/create">
                <input type="hidden" name="post_id" value="{{$post[0]->id}}"/>
                <input class = "btn btn-primary" type="submit" name="action" value="Send a proposal">
                </form>   
            </div>
            <div class="col-md-auto">
                {!! Form::open(['action' => ['PostsController@destroy', $post[0]->id], 'method' => 'POST']) !!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
                {!! Form::close() !!}     
            </div>
            <div class="col-md-auto">
                {!! Form::open(['action' => ['FeedbacksController@create',$post[0]->id], 'method' => 'GET']) !!}
                {{Form::hidden('_method','POST')}}
                {{Form::submit('Report', ['class'=> 'btn btn-warning'])}}
                {!! Form::close() !!}    
            </div>
        </div>
    </div>

    


@endsection