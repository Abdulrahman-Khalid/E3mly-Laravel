@extends('layouts.app')
@section('content')
    <h1>Proposals</h1>
    @if(count($proposals) > 0)
        @foreach($proposals as $proposal)
            <div class="well well-lg">
                <h3>Proposal from {{$proposal->name}}</h3>
                <small>sent at {{$proposal->created_at}}</small>
                <br>
                <br>
                <p>{{$proposal->body}}</p>
                <p class="font-weight-bold font-italic">Proposed cost = {{$proposal->cost}}</p>
                <div class="container">
                    <div class="row">
                        <div class="col-md-auto">
                         {!! Form::open(['action' => ['ProjectsController@create',$proposal->id], 'method' => 'GET']) !!}
                        {{Form::hidden('_method','POST')}}
                        {{Form::submit('Accept', ['class'=> 'btn btn-primary'])}}
                        {!! Form::close() !!} 
                        </div>
                        
                        <div class="col-md-auto">
                         {!! Form::open(['action' => ['ProposalController@destroy', $proposal->id], 'method' => 'POST']) !!}
                        {{Form::hidden('_method','DELETE')}}
                        {{Form::submit('Decline', ['class'=> 'btn btn-danger'])}}
                        {!! Form::close() !!} 
                        </div>
                        
                        <div class="col-md-auto">
                         {!! Form::open(['action' => ['FeedbacksController@create',$proposal->id], 'method' => 'GET']) !!}
                        {{Form::hidden('_method','POST')}}
                        {{Form::submit('Report', ['class'=> 'btn btn-warning'])}}
                        {!! Form::close() !!} 
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>This post doesn't have any proposal</p>
    @endif
@endsection