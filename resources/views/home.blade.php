@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="card-title mb-4">
                        <div class="d-flex justify-content-start">
                            <div class="image-container">
                                <img src="http://placehold.it/150x150" id="imgProfile" style="width: 150px; height: 150px" class="img-thumbnail" />
                                <div class="middle">
                                    <input type="button" class="btn btn-secondary" id="btnChangePicture" value="Change" />
                                    <input type="file" style="display: none;" id="profilePicture" name="file" />
                                </div>
                            </div>
                            <div class="userData ml-3">
                                <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="javascript:void(0);">{{$user->name}}</a></h2>
                            </div>
                            <div class="ml-auto">
                                <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard Changes" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">Basic Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Posts-tab" data-toggle="tab" href="#Posts" role="tab" aria-controls="Posts" aria-selected="false">Posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="receivedProposals-tab" data-toggle="tab" href="#receivedProposals" role="tab" aria-controls="receivedProposals" aria-selected="false">Received Proposals</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="sentProposals-tab" data-toggle="tab" href="#sentProposals" role="tab" aria-controls="sentProposals" aria-selected="false">Sent Proposals</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Projects-tab" data-toggle="tab" href="#Projects" role="tab" aria-controls="Projects" aria-selected="false">Projects</a>
                                </li>
                            </ul>
                            <div class="tab-content ml-1" id="myTabContent">
                                <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                    

                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Full Name</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$user->name}}
                                        </div>
                                    </div>
                                    <hr />

                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Birth Date</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$user->birthdate}}
                                        </div>
                                    </div>
                                    <hr />
                                    
                                    
                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Gender</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$user->gender}}
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Points</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$user->points}}
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <label style="font-weight:bold;">Bio</label>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            {{$user->bio}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="receivedProposals" role="tabpanel" aria-labelledby="receivedProposals-tab">
                                    @if(count($userPosts) > 0)
                                    <h1>Select a post to view its proposals</h1>
                                        @foreach($userPosts as $userPost)
                                        <div class="well well-lg">
                                            <h3><a href="/proposals/{{$userPost->id}}">{{$userPost->title}}</a></h3>
                                            <small>post created at {{$userPost->created_at}}</small>
                                        </div>
                                        @endforeach
                                    @else
                                    <p>You haven't posted anything yet</p>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="Projects" role="tabpanel" aria-labelledby="Projects-tab">
                                @if(count($userProjects) > 0)
                                    @foreach($userProjects as $userProject)
                                    <div class="well well-lg">
                                        <h3><a href="/projects/{{$userProject->id}}">{{$userProject->title}}</a></h3>
                                        <strong>{{$userProject->category}}</strong>
                                        @if($userProject->status == 2)
                                        <div>Status: <span style="color: brown;">Finished</span></div>
                                        @endif
                                        @if($userProject->status == 1)
                                        <div>Status: <span style="color: violet;">Pending</span></div>
                                        @endif
                                        @if($userProject->status == 0)
                                        <div style="font-style: italic;">Status: <span style="color: green;">In progress</span></div>
                                        @endif
                                        <small>project initiated on {{$userProject->created_at}}</small>
                                    </div>
                                    @endforeach
                                    @else
                                    <p>You haven't initiated any project yet</p>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="sentProposals" role="tabpanel" aria-labelledby="sentProposals-tab">
                                    @if(count($sentProposals) > 0)
                                    <h1>Select a proposal to edit</h1>
                                        @foreach($sentProposals as $sentProposal)
                                        <div class="container">
                                            <div class="row">
                                                <div class="col col-lg-4">
                                                    <div class="well well-lg">
                                                        <h3><a href="/proposals/{{$sentProposal->id}}/edit">{{$sentProposal->title}}</a></h3>
                                                        <small>proposal sent at {{$sentProposal->created_at}}</small>
                                                    </div>
                                                </div>    
                                                <div class="col col-md-auto">
                                                    {!! Form::open(['action' => ['ProposalController@destroy', $sentProposal->id], 'method' => 'POST']) !!}
                                                    {{Form::hidden('_method','DELETE')}}
                                                    {{Form::submit('Cancel', ['class'=> 'btn btn-outline-danger'])}}
                                                    {!! Form::close() !!} 
                                                </div> 
                                            </div>
                                        </div>       
                                        @endforeach
                                    @else
                                    <p>You haven't sent any proposal yet</p>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="Posts" role="tabpanel" aria-labelledby="Posts-tab">
                                    @if(count($userPosts) > 0)
                                        @foreach($userPosts as $userPost)
                                        <div class="well well-lg">
                                            <h3><a href="/posts/{{$userPost->id}}">{{$userPost->title}}</a></h3>
                                            <small>post created at {{$userPost->created_at}}</small>
                                        </div>
                                        @endforeach
                                    @else
                                    <p>You haven't posted anything yet</p>
                                    @endif
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
