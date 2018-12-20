@extends('layouts.app')

@section('content')
    <h1 style="margin: auto; width: 50%; height: 50%; padding: 10px; text-align: center;">Please Confirm Project Intialization</h1>
    <div class="row" style="margin: auto; width: 50%; height: 50%; padding: 10px; text-align:center;">
    	<span style = "text-align: center; margin: auto;">
	        {!! Form::open(['action' => 'ProjectsController@store', 'method' => 'POST']) !!}
	        <input type="hidden" name="proposal_id" value="{{$_GET['proposal_id']}}"/>
        	{{Form::submit('Confirm', ['class'=> 'btn btn-success btn-lg'])}}
        	{!! Form::close() !!}
        </span>
    </div>
    <div class="row" style="margin: auto; width: 50%; height: 50%; padding: 10px; text-align:center;" >
        <a href="{{ URL::previous() }}" class = "btn btn-danger btn-lg" style="margin: auto; text-align:center;">Decline</a>
    </div>
@endsection