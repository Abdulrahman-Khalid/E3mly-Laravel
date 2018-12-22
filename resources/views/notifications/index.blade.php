<?php
use App\Http\Controllers\NotificationsController as NC;
?>
@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="unread-tab" data-toggle="tab" href="#unread" role="tab" aria-controls="ProjectInfo" aria-selected="true">Un Read</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="read-tab" data-toggle="tab" href="#read" role="tab" aria-controls="read" aria-selected="false">Read</a>
                </li>
                
            </ul>
            <div class="tab-content ml-1" id="unreadTabContent">
                <div class="tab-pane fade show active" id="unread" role="tabpanel" aria-labelledby="ProjectInfo-tab">
                        @if(count($unreadNotifications) > 0)
                        @foreach($unreadNotifications as $unreadNotification)
                                @if($unreadNotification->type == 1) <!--you have a new porposal-->
                                    {!! Form::open(['action' => ['NotificationsController@store', $unreadNotification->id], 'method' => 'POST']) !!}
                                        <?php $link = "/proposals/{$unreadNotification->post_id}";?>
                                        {{Form::hidden('link', $link)}}
                                        {{Form::hidden('id', $unreadNotification->id)}}
                                        {{Form::submit('You have a new porposal', ['class' =>"alert alert-primary"])}}
                                    {!! Form::close() !!}
                                    <small>{{$unreadNotification->created_at}}</small>
                                @elseif($unreadNotification->type == 2) <!--you have a new project-->
                                    {!! Form::open(['action' => ['NotificationsController@store', $unreadNotification->id], 'method' => 'POST']) !!}
                                        <?php $link = "/projects/{$unreadNotification->project_id}";?>
                                        {{Form::hidden('link', $link)}}
                                        {{Form::hidden('id', $unreadNotification->id)}}
                                        {{Form::submit('Your porposal has been accepted start working in your project NOW!', ['class' =>"alert alert-primary"])}}
                                    {!! Form::close() !!}
                                    <small>{{$unreadNotification->created_at}}</small>
                                @elseif($unreadNotification->type == 3) <!--you have a new message-->
                                    {!! Form::open(['action' => ['NotificationsController@store', $unreadNotification->id], 'method' => 'POST']) !!}
                                        <?php $link = "/projects/{$unreadNotification->project_id}#Messaging";?>
                                        {{Form::hidden('link', $link)}}
                                        {{Form::hidden('id', $unreadNotification->id)}}
                                        {{Form::submit('You have a new message', ['class' =>"alert alert-primary"])}}
                                    {!! Form::close() !!}
                                    <small>{{$unreadNotification->created_at}}</small>
                                @endif                            
                                {!! Form::open(['action' => ['NotificationsController@destroy', $unreadNotification->id], 'method' => 'POST']) !!}
                                    {{Form::hidden('_method','DELETE')}}
                                    {{Form::submit('Delete', ['class'=> 'btn btn-danger btn-xs'])}}
                                {!! Form::close() !!}
                        @endforeach
                    @else
                        <p>No unread notifications found</p>
                    @endif
                </div>

                <div class="tab-pane fade" id="read" role="tabpanel" aria-labelledby="read-tab">
                        @if(count($readNotifications) > 0)
                        @foreach($readNotifications as $readNotification)
                                @if($readNotification->type == 1) <!--you have a new porposal-->
                                    <h3 class="alert alert-dark"><a href="/proposals/{{$readNotification->post_id}}">You have a new porposal</a></h3>
                                    <small>{{$readNotification->created_at}}</small>
                                @elseif($readNotification->type == 2) <!--you have a new project-->
                                    <h3 class="alert alert-dark"><a href="/projects/{{$readNotification->project_id}}">Your porposal has been accepted start work your project NOW!</a></h3>
                                    <small>{{$readNotification->created_at}}</small>
                                @elseif($readNotification->type == 3) <!--you have a new message-->
                                    <h3 class="alert alert-dark"><a href="/projects/{{$readNotification->project_id}}#Messaging">You have a new message</a></h3>
                                    <small>{{$readNotification->created_at}}</small>
                                @endif
                                {!! Form::open(['action' => ['NotificationsController@destroy', $readNotification->id], 'method' => 'POST']) !!}
                                    {{Form::hidden('_method','DELETE')}}
                                    {{Form::submit('Delete', ['class'=> 'btn btn-danger btn-small btn-xs'])}}
                                {!! Form::close() !!}
                        @endforeach
                    @else
                        <p>No read notifications found</p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection