@extends('layouts.app')

@section('content')


<h1>Proposals</h1>
@if(count($proposals) > 0)
        @foreach($proposals as $proposals)
            <div class="well well-lg">
                <h3><a href="/proposals/{{$proposals->id}}">{{$proposals->title}}</a></h3>
                <small>sent at {{$proposals->created_at}}</small>
            </div>
        @endforeach
        </footer> {{$proposals->links()}}</footer>
    @else
        <p>No proposals found</p>
    @endif

@endsection