@extends('layouts.app')

@section('content')
    <h1>Edit Data</h1>
    {!! Form::open(['action' => ['PostsController@update',$post->id],'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title',$post->title, ['class' => 'form-control','placeholder' => 'Title'])}}
        </div>

        <div class="form-group">
            {{Form::label('body', 'Date')}}
            {{Form::text('body',$post->body, ['class' => 'form-control','placeholder' => ''])}}
        </div>

        <div class="form-group">
            {{Form::label('body', 'Time')}}
            {{Form::text('body',$post->body, ['class' => 'form-control','placeholder' => ''])}}
        </div>
           
        {{Form::hidden('_method','PUT')}}
        {{Form::submit('Save',['class'=>'btn btn-default'])}}
        
    {!! Form::close() !!}
@endsection