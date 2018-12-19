@extends('layouts.app')

@section('content')
    <button onclick="goBack()" class="btn btn-primary">Back</button>
    <script>
    function goBack() {
      window.history.back();
    }
    </script>
    <h1>{{$post[0]->title}}</h1>
    <small>posted at {{$post[0]->created_at}}</small>
    <p>
        {!!$post[0]->body!!}
    </p>
    <hr>
    <div class="container">
        <div class="row">
            @if($user_id == $post[0]->user_id) 
            <div class="col-md-auto">
                <a href="/posts/{{$post[0]->id}}/edit" class="btn btn-dark">Edit</a> 
            </div>
            @endif
            @if(($user_id != $post[0]->user_id) && ($alreadyProposed < 1)) 
            <div class="col-md-auto">
                <form method="GET" action="/proposals/create">
                <input type="hidden" name="post_id" value="{{$post[0]->id}}"/>
                <input class = "btn btn-primary" type="submit" name="action" value="Send a proposal">
                </form>   
            </div>
            @endif
            @if($alreadyProposed > 0)
                <button type="button" class="btn btn-dark" style="text-align:center;">You have already proposed</button>
            @endif
            @if($user_id == $post[0]->user_id) 
            <div class="col-md-auto">
                {!! Form::open(['action' => ['PostsController@destroy', $post[0]->id], 'method' => 'POST']) !!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
                {!! Form::close() !!}     
            </div>
            @endif
            @if($post[0]->description_file != "nofile.pdf")
            <div class="col-md-auto">   
                <a href="/public/storage/ProjectDescriptions/{{$post[0]->description_file}}" download = "{{$post[0]->description_file}}">
                    <button type="button" class="btn btn-info">
                        <i class="fas fa-file-pdf fa-lg" style ="margin:5px;"></i>
                        <span>Download Description File</span>
                    </button>
                </a>
            </div>
            @endif
            @if($user_id != $post[0]->user_id) 
            <div class="col-md-auto">
                {!! Form::open(['action' => ['FeedbacksController@create',$post[0]->id], 'method' => 'GET']) !!}
                {{Form::hidden('_method','POST')}}
                {{Form::submit('Report', ['class'=> 'btn btn-warning'])}}
                {!! Form::close() !!}    
            </div>
            @endif
        </div>
    </div>
@endsection