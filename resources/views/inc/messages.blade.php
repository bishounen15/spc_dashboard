<div id="sys-messages">
@if(session('success'))
    <div class="alert alert-success" id="success-msg">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" id="fail-msg">
        {{session('error')}}
    </div>
@endif
</div>