@extends('layouts.app')

@section('content')
    <h1>{{$post->''}},{{$matsolderingpost->''}}</h1>
    
    <div>
        {!!$post-string!!}
        {!!$matsolderingpost-string!!}
    </div>

        Input on {{$post->created_at}}
        Input on {{$matsolderingpost->created_at}}


        <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>
        

        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method'=>'POST', 'class'=> 'pull-right'])!!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete',['class'=> 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection 