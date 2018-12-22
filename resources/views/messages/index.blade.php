@extends('layouts.app')
@section('content')
    @if(count($messages) > 0)
        @foreach($messages as $message)
            <div class="well well-lg">
                <h3><a href="/messages/{{$message->id}}">{{$message->body}}</a></h3>
                <small>Messaged at {{$message->created_at}}</small>
            </div>
            {!! Form::open(['action' => ['MessagesController@destroy', $message->id], 'method' => 'POST']) !!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
            {!! Form::close() !!}
        @endforeach
    @else
        <p>No message found</p>
    @endif
@endsection