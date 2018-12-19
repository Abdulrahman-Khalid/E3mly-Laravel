@extends('layouts.app')

@section('content')
    <h1>Create project</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Write your project title'])}}
        </div>
        <div class="form-group">
                {{Form::label('category', 'Category')}}
                {{Form::text('category', '', ['class' => 'form-control', 'placeholder' => 'Write the category of the project'])}}
            </div>
        <div class="form-group">
            {{Form::label('body', 'Description')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('min_cost', 'Minimum cost by points')}}
            {{Form::number('min_cost', '', ['class' => 'form-control', 'id' => 'minCost', 'min' => 1, 'max' => 1000000, 'placeholder' => "From", 'onchange' => "document.getElementById('maxCost').min=this.value"])}}
        </div>
        <div class="form-group">
            {{Form::label('max_cost', 'Maximum cost by points')}}
            {{Form::number('max_cost', '', ['class' => 'form-control', 'id' => 'maxCost', 'min' => "document.getElementById('minCost').value", 'max' => 1000000, 'placeholder' => "TO"])}}
        </div>
        <div class="form-group">
            {{Form::label('period', 'Period by number of days')}}
            {{Form::number('period', '', ['class' => 'form-control', 'min' => 1, 'max' => 1000, 'placeholder' => "Days"])}}
        </div>
        <div class="form-group">
                <input type="file" name="description_file" id="description_file">
                <label for="description_file" class="label-input">
                    <i class="fas fa-file-pdf fa-lg" style ="margin:5px;"></i>
                    <span id="label_span">Upload Description File</span>
                </label>
        </div>
        {{Form::submit('Submit', ['class'=> 'btn btn-success btn-lg', 'style' => 'margin-bottom:30px; text-align:center; height:3em; width:11em;'])}}
    {!! Form::close() !!}
@endsection