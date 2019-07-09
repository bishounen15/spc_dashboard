@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <data-maintenance 
        title="Trina Module Power Maintenance" 
        icon="fa fa-bolt" 
        source="df_module_cell_power"
        user_id="{{ Auth::user()->user_id }}"
        v-bind:columns="[
            {
                name: 'factory', 
                display_name: 'Factory', 
                placeholder: 'Ex: TVN, TTL, etc.',
                width: '25%',
                type: 'text',
                inquire: true
            }, 
            {
                name: 'code', 
                display_name: 'Cell Code', 
                placeholder: 'Ex: W6-O2, R4-N1, etc.',
                width: '20%',
                type: 'text',
                inquire: true,
                inquire_type: 'LIKE'
            }, 
            {
                name: 'power', 
                display_name: 'Cell Power', 
                placeholder: 'Ex: 4.600 (with 3 decimal digits)',
                width: '20%',
                type: 'text',
                inquire: false
            }, 
            {
                name: 'EFF', 
                display_name: 'Efficiency', 
                placeholder: 'Ex: 19% (input should be 1900)',
                width: '20%',
                type: 'text',
                inquire: false
            }
    ]"></data-maintenance>
</div>
@endsection