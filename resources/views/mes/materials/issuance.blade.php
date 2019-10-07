@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <material-issuance
            role="{{ Auth::user()->mes_access == 1 ? Auth::user()->mes_role : (Auth::user()->sysadmin == 1 ? 'sysadmin' : '') }}"
            default_date="{{date('Y-m-d')}}"
            requestor="{{Auth::user()->user_id}}">
        </material-issuance>
    </div>
@endsection