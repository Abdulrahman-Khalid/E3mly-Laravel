@extends('layouts.app')

@section('content')
    <a href="/messages" class="btn btn-primary" role="button">Back</a>
    <h1>{{$message[0]->title}}</h1>
    <div>
        {!!$message[0]->body!!}
    </div>
    <hr>
    <small>Messaged at {{$message[0]->created_at}}</small>

    {!! Form::open(['action' => ['MessagesController@destroy', $message[0]->id], 'method' => 'POST']) !!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
    {!! Form::close() !!}
@endsection