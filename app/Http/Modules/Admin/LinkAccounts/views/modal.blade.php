<style>.modal-backdrop{position: unset;}</style>

<div class="modal fade" id="link_modal" tabindex="-1" role="dialog" aria-labelledby="elinkmodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5 class="modal-title" id="modal_title">Link Account</h5>
        </div>
        <div class="modal-body">
                {{Form::open()}}
                <div action="form-group">
                        <input type="hidden" class="form-control group_id" name="l_group_id">
                        <label for="l_link_to">Link to</label>
						<input type="text" class="form-control link_to" name="lt_username" disabled>
                </div>
                <div action="form-group">
                        <label for="l_link_with">Enter Username</label>
                        <input type="text" class="form-control link_username" name="link_username">
                        <span class="help-block text-danger" id="error_username"></span>
                </div>
                {{Form::close()}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="link_btn_modal"><i class="fa fa-link"></i> Link</button>
        </div>
        </div>
    </div>
</div>

<div id="error_link_modal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fas fa-exclamation-circle"></i>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
            </div>
            <div class="modal-body text-center">
                <p>You have reached the maximum limit of accounts.</p>
                <button class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div id="error2_link_modal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fas fa-exclamation-circle"></i>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
            </div>
            <div class="modal-body text-center">
                <p>No data found.</p>
                <button class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<div id="succes_link_modal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fas fa-exclamation-circle"></i>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
            </div>
            <div class="modal-body text-center">
                <p>You have successfully linked accounts.</p>
                <button class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>