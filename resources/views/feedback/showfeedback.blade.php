@extends('layouts.app')

@section('content')
    
    <a href="/feedback" class="btn btn-primary" role="button">Back to feedbacks</a>
    
    <!--this one displays the individual feedback in an individual route-->
    <!--IDK why ro use #fb[0] instead of just $fd, but somehow it works-->

    @if($fb == [])
        <h1>There is no Feedback with such an ID</h1>
	@else 

    <h1>{{$fb[0]->type}}</h1>
    
    <div>
        {!!$fb[0]->body!!}
    </div>
    <hr>
    <small>posted at {{$fb[0]->created_at}}</small>

     @endif



     <!--NOW I need a Solving methods
        1-Ignore
        2-Remove the Post
        but before that, I just need to make sure that I have the Post_id
     -->


@endsection