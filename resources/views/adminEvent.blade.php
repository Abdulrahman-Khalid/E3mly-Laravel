@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add your Event here') }}</div>

                <div class="card-body">
                    {!! Form::open(['action' => ['AdminController@addevent'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}	
                       
                <div class="input-group mb-3">

                  <input type="text" name="event" class="form-control" placeholder='{{$event["body"]}}' value='{{$event["body"]}}'aria-describedby="basic-addon2">
                  <div class="input-group-append">
                   
                  </div>
                </div>
                  
                    <input type="hidden" name="admin_id" value="{{$event['id']}}"/>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                           
                        </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
