@extends('layouts.app')
@section('content')
    <h1>Posts</h1>
    @if(count($messages) > 0)
        @foreach($messages as $message)
            <div class="well well-lg">
                <h3><a href="/messages/{{$message->id}}">{{$message->body}}</a></h3>
                <small>Messaged at {{$message->created_at}}</small>
            </div>
        @endforeach
    @else
        <p>No message found</p>
    @endif
@endsection