@component('mail::message')
# Yield Dashboard Automation {{-- # {{ $content['title'] }} --}}

{{ $abc = $content['details'] }}

{{ $content['updated_by'] }}:

@component('mail::table')
| Team                    | Date                    | Shift                   |
| ----------------------- |:-----------------------:|:-----------------------:|
| {{ $content['team'] }}  | {{ $content['date'] }}  | {{ $content['shift'] }} |
@endcomponent

@component('mail::table')
| Field                   | Old Value               | New Value               |
| ----------------------- |:-----------------------:|:-----------------------:|
@foreach($content["last_edit"] as $updates)
| {{ $updates['field'] }} | {{ $updates['old'] }}   | {{ $updates['new'] }}   |
@endforeach
@endcomponent

Reason for Updating:

{{ $content['remarks'] }}

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br> 
{{ config('app.name') }} Systems Administrator
@endcomponent
