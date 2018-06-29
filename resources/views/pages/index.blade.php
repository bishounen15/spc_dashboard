@extends('layouts.app')
@section('content')
        <title>{{config('app.name', 'SOLARPH')}}</title>
<div class="jumbotron text-center">
        <h1>Welcome to Solar Philippines!</h1>
        <p>Solar Philippines Module Manufaturing Corporation</p>
        <p>
                @guest
                <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">LOGIN</a>
                @else
                <a class="btn btn-primary btn-lg" href="{{ route('apps') }}" role="button">GO TO APPS</a>
                @endguest
        </p> 
        </div>
@endsection