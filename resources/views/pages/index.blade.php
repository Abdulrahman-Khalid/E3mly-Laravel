@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome To <span class="text-primary">E3mly</span></h1>
        <p>This is a laravel application from the "Laravel From Scratch" YouTube series</p>
        <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
    </div>
@endsection