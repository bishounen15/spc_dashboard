@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <portal-maintenance 
            title="Item Maintenance" 
            icon="fas fa-box-open" 
            source="im01"
            id_field="id"
            user_id="{{ Auth::user()->user_id }}"
            v-bind:allow_delete=true
            v-bind:allow_edit=true
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
                    display_name: 'Base UOFM',
                    placeholder: 'Enter UOFM', 
                    type: 'text'
                },
                {
                    name: 'uofm_issue', 
                    display_name: 'Issuance UOFM',
                    placeholder: 'Enter Issuance UOFM', 
                    type: 'text',
                    hide_column: true
                },
                {
                    name: 'conv_issue', 
                    display_name: 'Issuance Conversion',
                    placeholder: 'Conversion to base uofm', 
                    type: 'number',
                    min: '0',
                    max: '100000',
                    step: '.00001',
                    hide_column: true
                },
                {
                    name: 'item_category', 
                    display_name: 'Item Category',
                    placeholder: 'Enter Item Category', 
                    type: 'select',
                    static_list: [
                        {
                            value: 'rawmat',
                            caption: 'Raw Materials'
                        },
                        {
                            value: 'packaging',
                            caption: 'Packaging Materials'
                        }
                    ],
                    inquire: true,
                }, 
                {
                    name: 'supplier', 
                    display_name: 'Supplier',
                    placeholder: 'Enter Supplier', 
                    type: 'text',
                    inquire: true,
                }
        ]"></portal-maintenance>
    </div>
@endsection