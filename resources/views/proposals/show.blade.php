@extends('layouts.app')
@section('content')
    <h1>Received proposals</h1>
    @if(count($proposals) > 0)
        @foreach($proposals as $proposal)
            <div class="well well-lg">
                <h3>Proposal from {{$proposal->name}}</h3>
                <small>sent at {{$proposal->created_at}}</small>
                <br>
                <br>
                <p>{!!$proposal->body!!}</p>
                <p class="font-weight-bold font-italic">Proposed cost = {{$proposal->cost}}</p>
                <div class="container">
                    <div class="row">
                        <div class="col-md-auto">
                            <form method="GET" action="/projects/create">
                            <input type="hidden" name="proposal_id" value="{{$proposal->id}}"/>
                            <input class = "btn btn-primary" type="submit" name="action" value="Accept">
                            </form>   
                        </div>
                        
                        <div class="col-md-auto">
                            {!! Form::open(['action' => ['ProposalController@destroy', $proposal->id], 'method' => 'POST']) !!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::submit('Decline', ['class'=> 'btn btn-danger'])}}
                            {!! Form::close() !!} 
                        </div>

                        @if($proposal->details_file != "nofile.pdf")
                        <div class="col-md-auto">
                            <a href="/public/storage/ProjectDescriptions/{{$proposal->details_file}}" download>
                                <button type="button" class="btn btn-info">
                                    <i class="fas fa-file-pdf fa-lg" style ="margin:5px;"></i>
                                    <span>Download Description File</span>
                                </button>
                            </a>
                        </div>
                        @endif
                        
                        
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>This post doesn't have any proposal</p>
    @endif
@endsection