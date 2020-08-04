@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <portal-maintenance 
        title="Received Materials Information" 
        icon="fas fa-pallet" 
        source="mat01"
        user_id="{{ Auth::user()->user_id }}"
        v-bind:xl_import="true"
        v-bind:columns="[
            {
                name: 'DATE_RECEIVED', 
                display_name: 'Date Received', 
                type: 'date',
                inquire: true
            },
            {
                name: 'PONUMBER', 
                display_name: 'PO Number', 
                placeholder: 'Enter Cell PO Number',
                type: 'text',
                inquire: true,
                hide_column: true
            }, 
            {
                name: 'INVOICENO', 
                display_name: 'Invoice Number',
                placeholder: 'Enter Invoice Number', 
                type: 'text',
                hide_column: true
            }, 
            {
                name: 'REGISTRATION', 
                display_name: 'Govt. Registration', 
                placeholder: 'Enter Govt. Registration',
                type: 'select',
                static_list: [
                    {
                        value: 'PEZA',
                        caption: 'PEZA'
                    },
                    {
                        value: 'BOI',
                        caption: 'BOI'
                    }
                ],
                inquire: true
            }, 
            {
                name: 'PALLETNO', 
                display_name: 'Pallet No.',
                placeholder: 'Enter Pallet No.', 
                type: 'text',
                hide_column: true
            }, 
            {
                name: 'PARTNUMBER', 
                display_name: 'Part No.',
                placeholder: 'Enter Part No.', 
                type: 'text',
                inquire: true
            }, 
            {
                name: 'DESCRIPTION', 
                display_name: 'Description',
                placeholder: 'Enter Description', 
                type: 'text'
            }, 
            {
                name: 'LOTNUMBER', 
                display_name: 'Lot Number',
                placeholder: 'Enter Lot No.', 
                type: 'text',
                inquire: true
            }, 
            {
                name: 'SPEC01', 
                display_name: 'Efficiency',
                placeholder: 'Enter Efficiency', 
                percentage: true,
                type: 'text'
            }, 
            {
                name: 'SPEC02', 
                display_name: 'Color',
                placeholder: 'Enter Color', 
                type: 'text',
                hide_column: true
            }, 
            {
                name: 'RECQTY', 
                display_name: 'Received Qty',
                placeholder: 'Enter Received Qty', 
                type: 'text'
            }
    ]"></portal-maintenance>
</div>
@endsection