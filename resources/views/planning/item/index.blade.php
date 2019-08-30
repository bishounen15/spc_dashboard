@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <portal-maintenance 
            title="Item Maintenance" 
            icon="fas fa-box-open" 
            source="im01"
            user_id="{{ Auth::user()->user_id }}"
            v-bind:allow_delete=true
            v-bind:xl_import="true"
            v-bind:columns="[
                {
                    name: 'item_code', 
                    display_name: 'Part Number', 
                    placeholder: 'Enter Part Number',
                    type: 'text',
                    inquire: true,
                    inquire_type: 'LIKE'
                },
                {
                    name: 'item_desc', 
                    display_name: 'Description', 
                    placeholder: 'Enter Item Description',
                    type: 'text',
                    inquire: true
                }, 
                {
                    name: 'item_class', 
                    display_name: 'Item Class',
                    placeholder: 'Enter Item Class', 
                    type: 'select',
                    list_route: 'itemclass/lookup',
                    inquire: true
                }, 
                {
                    name: 'uofm_base', 
                    display_name: 'UOFM',
                    placeholder: 'Enter UOFM', 
                    type: 'text'
                }
        ]"></portal-maintenance>
    </div>
@endsection