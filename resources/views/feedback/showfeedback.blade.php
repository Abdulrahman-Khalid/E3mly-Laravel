@extends('layouts.app')

@section('content')
    
    <a href="/feedback" class="btn btn-primary" role="button">Back to feedbacks</a>
    
    <!--this one displays the individual feedback in an individual route-->
    <!--IDK why ro use #fb[0] instead of just $fd, but somehow it works-->

    @if($fb == [])
        <h1>There is no Feedback with such an ID</h1>
	@endif 

    <h1>{{$fb[0]->type}}</h1>
    
    <div>
        {!!$fb[0]->body!!}
    </div>

    <hr>
    <small>reported at {{$fb[0]->created_at}}</small>
    <!--
    I need a few bottuns
    1-Ignore Feedback--check
    2-Delete that post--check
    3-Report that user--lets
    -->
    @if(Auth::guard('moderator')->check())
    {!! Form::open(['action' => ['FeedbacksController@destroy', $fb[0]->id], 'method' => 'POST']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Ignore', ['class'=> 'btn btn-warning'])}}
    {!! Form::close() !!}


    {!! Form::open(['action' => ['PostsController@destroy', $fb[0]->post_id], 'method' => 'POST']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete Post', ['class'=> 'btn btn-danger'])}}
    {!! Form::close() !!}


   
    <form method="GET" action="/feedback/create">
        <input type="hidden" name="post_id" value="{{$fb[0]->post_id}}"/>
        <input class ="btn btn-warning" type="submit" name="Action" value="Request this user to be Deleted"/>
    </form>
    @else <!--Then the guard is admin-->
     {!! Form::open(['action' => ['FeedbacksController@destroy', $fb[0]->id], 'method' => 'POST']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Ignore this report', ['class'=> 'btn btn-warning'])}}
    {!! Form::close() !!}

    
    {!! Form::open(['action' => ['HomeController@destroy', $fb[0]->post_id], 'method' => 'POST']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete that user', ['class'=> 'btn btn-danger'])}}
    {!! Form::close() !!} 
  
    @endif



     

@endsection