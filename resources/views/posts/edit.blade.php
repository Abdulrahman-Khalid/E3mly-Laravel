@extends('layouts.app')

@section('content')
    <h1>Edit project</h1>
    {!! Form::open(['action' => ['PostsController@update',$post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Write your project title'])}}
        </div>
        <div class="form-group">
                {{Form::label('category', 'Category')}}
                {{Form::text('category', $post->category, ['class' => 'form-control', 'placeholder' => 'Write the category of the project'])}}
            </div>
        <div class="form-group">
            {{Form::label('body', 'Description')}}
            {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('min_cost', 'Minimum cost by points')}}
            {{Form::number('min_cost', $post->min_cost, ['class' => 'form-control', 'id' => 'minCost', 'min' => 1, 'max' => 1000000, 'placeholder' => "From", 'onchange' => "document.getElementById('maxCost').min=this.value"])}}
        </div>
        <div class="form-group">
            {{Form::label('max_cost', 'Maximum cost by points')}}
            {{Form::number('max_cost', $post->max_cost, ['class' => 'form-control', 'id' => 'maxCost', 'min' => "document.getElementById('minCost').value", 'max' => 1000000, 'placeholder' => "TO"])}}
        </div>
        <div class="form-group">
            {{Form::label('period', 'Period by number of days')}}
            {{Form::number('period', $post->period, ['class' => 'form-control', 'min' => 1, 'max' => 1000, 'placeholder' => "Days"])}}
        </div>
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Submit', ['class'=> 'btn btn-success btn-lg', 'style' => 'margin-bottom:30px; text-align:center; height:3em; width:11em;'])}}
    {!! Form::close() !!}
@endsection