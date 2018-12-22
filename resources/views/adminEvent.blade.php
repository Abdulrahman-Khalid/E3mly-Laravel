@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add your Event here') }}</div>

                <div class="card-body">
                    <form method="POST" action="/adminEvent/store">
                    {!! Form::open(['action' => ['AdminController@addevent'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}	
                       

                    <div class="form-group">
                        {{Form::label('body', 'Event')}}
                       
                        {{Form::textarea('event',$event["body"], ['id' => 'article-ckeditor', 'class' => 'form-control'])}}
                    </div>
                    <input type="hidden" name="admin_id" value="{{$event['id']}}"/>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
