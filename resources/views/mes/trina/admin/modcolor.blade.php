@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <data-maintenance 
        title="Trina Module Color Maintenance" 
        icon="fa fa-palette" 
        source="df_module_cell_color"
        user_id="{{ Auth::user()->user_id }}"
        v-bind:columns="[
            {
                name: 'factory', 
                display_name: 'Factory', 
                placeholder: 'Cell Supplier (Ex: TVN, TTL)',
                width: '25%',
                type: 'text',
                inquire: true
            }, 
            {
                name: 'ModuleColor', 
                display_name: 'Module Color',
                placeholder: 'Module Color System (Ex: 1 ~ 9, A ~ E)', 
                width: '30%',
                type: 'text',
                inquire: true
            }, 
            {
                name: 'color', 
                display_name: 'Cell Color', 
                placeholder: 'Cell Color Code (Ex: HY-1, DY-1)',
                width: '30%',
                type: 'text',
                inquire: true,
                inquire_type: 'LIKE'
            }
    ]"></data-maintenance>
</div>
@endsection