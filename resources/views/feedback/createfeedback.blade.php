@extends('layouts.app')

@section('content')
    <h1>Create Feedback</h1>
    {!! Form::open(['action' => 'FeedbacksController@store', 'method' => 'POST']) !!}

        <div class="form-group">
            {{Form::label('title', 'Problem')}}
            
            <div class="form-check">
            {{ Form::radio('name', 'Breaks the Application Rules',true)}}
            {{Form::label('title', 'Breaks the Application Rules'),['class'=>"form-check-label"]}}
             </div>

             <div class="form-check">
            {{ Form::radio('name', 'Nudity')}}
            {{Form::label('title', 'Nudity'),['class'=>"form-check-label"]}}
             </div>

             <div class="form-check">
            {{ Form::radio('name', 'Spam')}}
            {{Form::label('title', 'Spam'),['class'=>"form-check-label"]}}
             </div>

             <div class="form-check">
            {{ Form::radio('name', 'Harassment')}}
            {{Form::label('title', 'Harassment'),['class'=>"form-check-label"]}}
             </div>

             <div class="form-check">
            {{ Form::radio('name', 'Violence')}}
            {{Form::label('title', 'Violence'),['class'=>"form-check-label"]}}
             </div>

             <div class="form-check">
            {{ Form::radio('name', 'Hate Speech')}}
            {{Form::label('title', 'Hate Speech'),['class'=>"form-check-label"]}}
             </div>

             <div class="form-check">
            {{ Form::radio('name', 'Others')}}
            {{Form::label('title', 'Others'),['class'=>"form-check-label"]}}
             </div>
 
            
        </div>

        <div class="form-group">
            {{Form::label('body', 'Description')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Write your feedback description in detail'])}}
        </div>



        {{Form::submit('Submit', ['class'=> 'btn btn-success'])}}
    {!! Form::close() !!}


@endsection