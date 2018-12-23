@extends('layouts.app')

@section('content')
    <h1>Edit proposal</h1>
    {!! Form::open(['action' => ['ProposalController@update', $proposal->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('body', 'Description')}}
            {{Form::textarea('body', $proposal->body, ['id' => 'article-ckeditor', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('cost', 'Proposed cost')}}
            {{Form::number('cost', $proposal->cost, ['class' => 'form-control', 'id' => 'Cost', 'min' => 1, 'max' => 1000000, 'placeholder' => "cost"])}}
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-auto">
                    {{Form::hidden('_method','PUT')}}
                    {{Form::submit('Submit', ['class'=> 'btn btn-success btn-lg', 'style' => 'margin-bottom:30px; text-align:center; height:3em; width:11em;'])}}
                    {!! Form::close() !!} 
                </div>
            </div>
         </div>
        
@endsection