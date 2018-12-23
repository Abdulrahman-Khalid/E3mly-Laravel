@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title mb-4">
                        <div class="d-flex justify-content-start">
                            <div class="userData ml-3">
                                <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold;">{{$project->title}}</h2>
                                @if($project->status == 2)
                                <div style="color: brown;">Finished</div>
                                @endif
                                @if(($project->status == 1)&&($craftman->id == $user_id))
                                <div style="color: violet;">Pending customer acceptance</div>
                                @endif
                                @if(($project->status == 1)&&($customer->id == $user_id))
                                <div style="color: violet;">Pending your acceptance</div>
                                @endif
                                @if($project->status == 0)
                                <div style="color: green; font-style: italic;">In progress</div>
                                @endif
                                <small>project initiated on {{$project->created_at}}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="ProjectInfo-tab" data-toggle="tab" href="#ProjectInfo" role="tab" aria-controls="ProjectInfo" aria-selected="true">Project Info</a>
                                </li>
                                @if($project->status != 2)
                                <li class="nav-item">
                                    <a class="nav-link" id="Messaging-tab" data-toggle="tab" href="#Messaging" role="tab" aria-controls="Messaging" aria-selected="false">Messaging Tab</a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content ml-1" id="ProjectInfoTabContent">
                                <div class="tab-pane fade show active" id="ProjectInfo" role="tabpanel" aria-labelledby="ProjectInfo-tab">
                                    
                                    <div class="row">
                                        @if($project->craftman_id == $user_id)
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Customer</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$customer->name}}
                                        </div>
                                        @else
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Craftsman</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$craftman->name}}
                                        </div>
                                        @endif
                                    </div>
                                    <hr />

                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Description</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                           <p>{!!$project->body!!}</p> 
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Category</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                           {{$project->category}}
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Agreed-upon Cost</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$project->cost}}
                                        </div>
                                    </div>
                                    <hr />
                                    
                                    <div class="row">
                                        @if($project->status == 2)
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Finished On</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$project->finish_date}}  
                                        </div>
                                        @else
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Due Date</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$project->suppose_to_finish}}  
                                        </div>
                                        @endif
                                    </div>

                                    @if($project->description_file != "nofile.pdf")
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Description File</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <label for="description_file" class="label-input">
                                            <i class="fas fa-file-pdf fa-lg" style ="margin:5px;"></i>
                                            <span id="label_span">
                                                <a href="/public/storage/ProjectDescriptions/{{$project->description_file}}" download = "{{$project->description_file}}">
                                                     Download
                                                 </a>
                                            </span>
                                            </label>   
                                        </div>
                                    </div>
                                    <hr />
                                    @endif

                                    @if($project->status == 2)
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Rating</label>
                                        </div>
                                        <div class="col-md-8 col-6"> 
                                            @for($i = 0; $i < $project->rating; $i++)
                                            <span class="fa fa-star checked"></span>
                                            @endfor
                                            @for($i = 0; $i < (5 - $project->rating); $i++)
                                            <span class="fa fa-star"></span>
                                            @endfor
                                        </div>
                                    </div>
                                    @endif

                                    @if(($project->status == 1)&& ($customer->id == $user_id))
                                    <hr>
                                    {!! Form::open([ 'action' => ['ProjectsController@update',$project->id], 'method' => 'POST']) !!}
                                    {{Form::hidden('_method','PUT')}}
                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Rating</label>
                                        </div>
                                        <div class="col-md-8 col-6"> 
                                            <fieldset class="rating">
                                                <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                            </fieldset>
                                        </div>
                                    </div>
                                    {{Form::submit('Accept Pending Work', ['class'=> 'btn btn-success btn-lg float-right', 'style' => 'text-align:center; height:3em; width:11em;'])}}
                                    {!! Form::close() !!}
                                    @endif
                                    @if((($project->status)==0)&&($craftman->id == $user_id))
                                    {!! Form::open([ 'action' => ['ProjectsController@update',$project->id], 'method' => 'POST']) !!}
                                    {{Form::hidden('_method','PUT')}}
                                    {{Form::submit('Project is finished!', ['class'=> 'btn btn-success btn-lg float-right', 'style' => 'text-align:center; height:3em; width:11em;'])}}
                                    {!! Form::close() !!}
                                    @endif
                                    @if((($project->status)==1)&&($craftman->id == $user_id))
                                    <button type="button" class="btn btn-dark btn-lg float-right" style="text-align:center; height:3em; width:11em;">Pending</button>
                                    @endif                                    
                                </div>

                                <div class="tab-pane fade" id="Messaging" role="tabpanel" aria-labelledby="Messaging-tab">
                                    {{--Messages--}}
                                    @if(count($messages_users) > 0)
                                    @foreach($messages_users as $message_user)
                                        <a>{{$message_user->name}}</a>
                                        <div class="alert alert-secondary">
                                            <p>{!!$message_user->body!!}</p>
                                            <small>sent at: {{$message_user->created_at}}</small>
                                            @if($user_id == $message_user->user_id)
                                                {!! Form::open(['action' => ['MessagesController@destroy', $message_user->id], 'method' => 'POST']) !!}
                                                    {{Form::hidden('_method','DELETE')}}
                                                    {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
                                                {!! Form::close() !!}
                                            @endif
                                            @if($message_user->work_file != "nofile.pdf")
                                            <span id="label_span">
                                                <a href="/public/storage/MessageDescriptions/{{$message_user->work_file}}" download = "{{$message_user->work_file}}">
                                                    Download Attachment
                                                </a>
                                            </span>
                                            @endif
                                        </div>
                                    @endforeach
                                    @else
                                        <p>No message found</p>
                                    @endif
                                    {!! Form::open(['action' => ['MessagesController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                        <div class="form-group">
                                            {{Form::label('body', 'Add Message')}}
                                            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control'])}}
                                        </div>
                                        {{Form::hidden('project_id', $project->id)}}
                                        <div class="form-group">
                                            <input type="file" name="work_file" id="work_file">
                                            <label for="work_file" class="label-input">
                                                <i class="fas fa-file-pdf fa-lg" style ="margin:5px;"></i>
                                                <span id="label_span">Upload Description File</span>
                                            </label>
                                        </div>
                                        {{Form::submit('send', ['class'=> 'btn btn-success btn-lg'])}}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection