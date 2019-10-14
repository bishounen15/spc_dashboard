@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <bom-maintenance
        role="{{ Auth::user()->mes_access == 1 ? Auth::user()->mes_role : (Auth::user()->sysadmin == 1 ? 'sysadmin' : '') }}"></bom-maintenance>
    </div>
@endsection