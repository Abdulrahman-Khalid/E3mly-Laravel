@extends('layouts.app')

@section('content')
    <h1>Create project</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Write your project title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Description')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Write your project description in detail'])}}
        </div>
        {{Form::submit('Submit', ['class'=> 'btn btn-success'])}}
    {!! Form::close() !!}
@endsection