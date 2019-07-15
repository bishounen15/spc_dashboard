@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <portal-maintenance 
        title="Trina Module ID Sync" 
        icon="fas fa-sync" 
        source="lbl02"
        user_id="{{ Auth::user()->user_id }}"
        v-bind:columns="[
            {
                name: 'SERIALNO', 
                display_name: 'Serial Number', 
                placeholder: 'Enter Module Serial Number',
                lookup_source: true,
                lookup_route: 'trina/module/lookup',
                width: '20%',
                type: 'text',
                inquire: true
            }, 
            {
                name: 'LBLCNO', 
                display_name: 'Control No.',
                placeholder: 'System Control Number', 
                lookup_values: true,
                width: '10%',
                type: 'text',
            }, 
            {
                name: 'LBLTYPE', 
                display_name: 'Type',
                placeholder: '1 = Serial, 2 = Frame, 3 = Product', 
                default_value: '1',
                read_only: true,
                lookup_values: true,
                width: '5%',
                type: 'text',
                inquire: true
            }, 
            {
                name: 'PRODTYPE', 
                display_name: 'Prod. Type', 
                placeholder: 'Ex: TSM-PE14A, etc.', 
                lookup_values: true,
                width: '10%',
                type: 'text',
            }, 
            {
                name: 'CELLCOUNT', 
                display_name: 'Cell Count',
                placeholder: 'Number of Cells per Module', 
                lookup_values: true,
                width: '5%',
                type: 'text',
            }, 
            {
                name: 'CELLCOLOR', 
                display_name: 'Cell Type',
                placeholder: 'M for Mono, P for Poly, E for Mono PERC, etc.', 
                lookup_values: true,
                width: '5%',
                type: 'text',
            }, 
            {
                name: 'CUSTOMER', 
                display_name: 'Customer', 
                placeholder: 'Enter Customer', 
                default_value: 'TRINA',
                read_only: true,
                lookup_values: true,
                width: '10%',
                type: 'text',
                inquire: true,
            }, 
            {
                name: 'ORDERNO', 
                display_name: 'Order Number', 
                placeholder: 'Enter Work Order Number', 
                lookup_values: true,
                width: '10%',
                type: 'text',
                inquire: true,
            }, 
            {
                name: 'PRODLINE', 
                display_name: 'Line',
                placeholder: 'Assigned Production Line', 
                lookup_values: true,
                width: '5%',
                type: 'text',
            }, 
            {
                name: 'COLOR', 
                display_name: 'Color',
                placeholder: 'Module Color System', 
                lookup_values: true,
                width: '5%',
                type: 'text',
            }
    ]"></portal-maintenance>
</div>
@endsection