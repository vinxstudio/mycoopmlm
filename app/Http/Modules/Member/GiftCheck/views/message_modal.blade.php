{{-- message modal --}}
<style>
    .modal-backdrop{
        position: unset;
    }
</style>
<div id="message_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <h4 class="message"></h4>
            </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secodary" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-success" id="confirm">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>{{-- //message modal --}}