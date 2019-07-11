@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <data-maintenance 
        title="Trina Cell PO Information" 
        icon="fas fa-pallet" 
        source="solarph.po_data"
        user_id="{{ Auth::user()->user_id }}"
        xl_import="true"
        v-bind:columns="[
            {
                name: 'po_number', 
                display_name: 'PO Number', 
                placeholder: 'Enter Cell PO Number',
                width: '10%',
                type: 'text',
                inquire: true
            }, 
            {
                name: 'cell_lot', 
                display_name: 'Lot Number',
                placeholder: 'Enter / Scan Cell Lot', 
                width: '65%',
                type: 'text',
                inquire: true
            }, 
            {
                name: 'date_received', 
                display_name: 'Date Received', 
                width: '15%',
                type: 'date',
                inquire: true,
            }
    ]"></data-maintenance>
</div>
@endsection