@extends('layouts.app')
@section('content')
<div class="container-fluid">
        <div class="jumbotron text-center">
        <strong><h1>Welcome to Solar Philippines!</h1></strong>
        <hr>
        <h3>Solar Philippines Module <br> Manufaturing Corporation</h3>
        <p>
                @guest
                <br>
                <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">LOGIN</a>
                @else
                {{-- <a class="btn btn-primary btn-lg" href="{{ route('apps') }}" role="button">GO TO APPS</a> --}}
                @endguest
        </p> 
        </div>
</div>
@endsection