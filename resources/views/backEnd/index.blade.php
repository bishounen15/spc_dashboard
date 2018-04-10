@extends('layouts.app')
  
@section('content')
   

<div class="col-md-3">
        @include('backEnd.navs')
        </div>
        <div class="col-md-9">
        <div class="jumbotron text-center">
        <h1>Welcome to Solar Philippines!</h1>
        <p>Solar Philippines Module Manufaturing Corporation</p>
        <p><a class="btn btn-primary btn-lg" href="/posts/create" role="button">LOGIN</a></p>
        </div>
        </div>      

   
                
 @endsection