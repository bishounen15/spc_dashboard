@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <portal-maintenance 
        title="Work Order Information" 
        icon="fas fa-clipboard-list" 
        source="wor01"
        user_id="{{ Auth::user()->user_id }}"
        v-bind:allow_delete=true
        v-bind:columns="[
            {
                name: 'WOID', 
                display_name: 'Work Order ID', 
                placeholder: 'Enter Work Order ID',
                system_generated: 'portal/wo/generate',
                width: '15%',
                type: 'text',
                inquire: true,
                inquire_type: 'LIKE'
            },
            {
                name: 'WODATE', 
                display_name: 'Date', 
                placeholder: 'Enter Date',
                generate_series: true,
                width: '10%',
                type: 'date'
            }, 
            {
                name: 'PRODTYPE', 
                display_name: 'Product Type',
                placeholder: 'Enter Product Type', 
                width: '20%',
                type: 'select',
                list_route: 'prodtype/lookup',
                inquire: true
            }, 
            {
                name: 'WOTYPE', 
                display_name: 'Type',
                placeholder: 'Enter Work Order Type', 
                width: '10%',
                type: 'select',
                static_list: [
                    {
                        value: 'STANDARD',
                        caption: 'Standard'
                    },
                    {
                        value: 'ENG',
                        caption: 'Engineering'
                    }
                ],
                inquire: true
            }, 
            {
                name: 'WOCATEGORY', 
                display_name: 'Government Registration',
                placeholder: 'Enter Category', 
                width: '10%',
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
                inquire: true,
                generate_series: true
            }, 
            {
                name: 'WOSTATUS', 
                display_name: 'Status',
                placeholder: 'Enter Status', 
                width: '10%',
                type: 'text',
                default_value: 'OPEN'
            },
            {
                name: 'REMARKS', 
                display_name: 'Remarks', 
                placeholder: 'Enter Remarks (Will be displayed on Daily Report)',
                type: 'text',
                width: '10%'
            }
    ]"></portal-maintenance>
</div>
@endsection