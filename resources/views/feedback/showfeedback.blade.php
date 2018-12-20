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
    <!--
    Post info and user info
    -->
    
    
    @if(Auth::guard('moderator')->check())
        <div class="well well-lg">
            <h3>On Post: <a href="/posts/{{$fb[0]->post_id}}" target="_blanck">{{$fb[0]->post_title}}</a></h3>
            <form method="GET" action="/profile/{{$fb[0]->post_id}}">                 
                <input type="hidden" name="post_id" value="{{$fb[0]->post_id}}"/>
                <input class ="btn btn-info" type="submit" name="Action" value="Show User"/>
             </form>
            
        </div>
        <small>reported at {{$fb[0]->created_at}}</small>
            {!! Form::open(['action' => ['FeedbacksController@destroy', $fb[0]->id], 'method' => 'POST']) !!}
            {{Form::hidden('_method','DELETE')}}
            {{Form::submit('Ignore this report', ['class'=> 'btn btn-warning'])}}
            {!! Form::close() !!}
    @endif

   
   
    @if(Auth::guard('admin')->check())
     <div class="well well-lg">
        <h2>Take a look at his profile</h2>
        <h4><a href="/profile/{{$fb[0]->user_id}}" target="_blanck">{{$fb[0]->user_name}}</a></h4>
    </div>
    <small>reported at {{$fb[0]->created_at}}</small>
     {!! Form::open(['action' => ['FeedbacksController@destroy', $fb[0]->id], 'method' => 'POST']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Ignore this report', ['class'=> 'btn btn-warning'])}}
    {!! Form::close() !!}

    
   
    @endif



     

@endsection