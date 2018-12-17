@extends('layouts.app')
@section('content')
    <h1>Feedbacks</h1>
    @if(count($feedbacks) > 0)
        @foreach($feedbacks as $feedback)
            <!--this one displayes all the feedbacks against  users-->
            <div class="well well-lg">
                <h3><a href="/feedback/{{$feedback->id}}">{{$feedback->type}}</a></h3>
                <small>posted at {{$feedback->created_at}}</small>
            </div>
      
        @endforeach
    @else
        <p>No feedbacks found</p>
    @endif
@endsection