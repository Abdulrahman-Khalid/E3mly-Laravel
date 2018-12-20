@extends('layouts.app')
@section('content')
    <h1>Users</h1>
    @if(count($users) > 0)
        @foreach($users as $user)
            <div class="well well-lg">
                <h3><a href="/profile/{{$user->id}}">{{$user->name}}</a></h3>
                <small>mail  {{$user->email}}</small>
            </div>
        @endforeach
    @else
        <p>No Users found</p>
    @endif
@endsection