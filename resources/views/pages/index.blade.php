@extends('layouts.app')
@section('content')
        <title>{{config('app.name', 'SOLARPH')}}</title>
<div class="container-fluid">
        <div class="jumbotron text-center">
        <h1><strong>Welcome to HGS Philippines!</strong></h1>
        <h2>HGS Asset Management System</h3>
        <hr>
        <p>
                @guest
                <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">LOGIN</a>
                @else
                <a class="btn btn-primary btn-lg" href="/assets/general" role="button">GO TO ASSETS</a>
                @endguest
        </p> 
        </div>
</div>
@endsection