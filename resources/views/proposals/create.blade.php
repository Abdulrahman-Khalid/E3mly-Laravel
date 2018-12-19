@extends('layouts.app')

@section('content')
    <h1>Create a proposal</h1>
    {!! Form::open(['action' => 'ProposalController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('body', 'Description')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('cost', 'Proposed cost')}}
            {{Form::number('cost', '', ['class' => 'form-control', 'id' => 'Cost', 'min' => 1, 'max' => 1000000, 'placeholder' => "cost"])}}
        </div>
        <div class="form-group">
                <input type="file" name="description_file" id="description_file">
                <label for="description_file" class="label-input">
                    <i class="fas fa-file-pdf fa-lg" style ="margin:5px;"></i>
                    <span id="label_span">Upload Description File</span>
                </label>
        </div>

        <input type="hidden" name="post_id" value="{{$_GET['post_id']}}"/>

        {{Form::submit('Submit', ['class'=> 'btn btn-success btn-lg', 'style' => 'margin-bottom:30px; text-align:center; height:3em; width:11em;'])}}
        {!! Form::close() !!}
@endsection