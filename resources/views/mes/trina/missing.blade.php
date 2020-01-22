@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <missing-serials
        def_date="{{date('Y-m-d')}}">
    </missing-serials>
</div>
@endsection

@push('jscript')
<script>
    
</script>
@endpush