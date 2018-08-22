<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delete Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id" value="0">
            <p>Do you want to delete "<small><span id="descr"></span></small>"?</p>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary btn-yes remove-record">Yes</a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        </div>
        </div>
    </div>
</div>

@push('jscript')
<script>
    // $('#confirm-delete').on('show.bs.modal', function(e) {
    //     console.log("test");
    //     $("#descr").html($(e.relatedTarget).attr('id'));
    //     // $(this).find('.btn-yes').attr('href', $(e.relatedTarget).data('href'));
    // });
</script>
@endpush