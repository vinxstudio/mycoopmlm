<style>.modal-backdrop{position: unset;}</style>
<!-- Modal for adding -->
<div class="modal fade" id="announcement" role="dialog">
    <div class="modal-dialog">
        
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Announcement</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="announcement_title">Announcement Title:</label>
                        <input type="text" class="form-control a_title" name="announcement_title">
                    </div>
                    <div class="form-group">
                        <label for="announcement_details">Announcement Details:</label>
                        <textarea class="form-control a_details" rows="5" name="announcement_details"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="announcement_display">Announcement Date:</label>
                        <input class="form-control a_date date" rows="5" name="announcement_date">
                    </div>
                    <div class="form-group">
                        <label for="announcement_from">From:</label>
                        <input class="form-control a_from">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="a_add">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
            </div>
        </div>
      
    </div>
</div>

<!-- Modal for editing -->
<div class="modal fade" id="announcement_edit" role="dialog">
    <div class="modal-dialog">
        
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Announcement</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="announcement_title">Announcement Title:</label>
                        <input type="text" class="form-control edit_title" name="e_announcement_title">
                    </div>
                    <div class="form-group">
                        <label for="announcement_details">Announcement Details:</label>
                        <!-- <span class="limit_count"><b>0</b>/255</span> -->
                        <textarea class="form-control edit_details" rows="5" name="e_announcement_details"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="announcement_display">Announcement Date:</label>
                        <input class="form-control edit_date date" rows="5" name="e_announcement_date"></input>
                    </div>
                    <div class="form-group">
                        <label for="announcement_from">From:</label>
                        <input class="form-control edit_from">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#announcement_warn">Update</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
            </div>
        </div>
      
    </div>
</div>

<!-- Modal for warning -->
<div class="modal fade" id="announcement_warning" role="dialog">
    <div class="modal-dialog">
        
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Announcement</h4>
            </div>
            <div class="modal-body">
                <h2>Are you sure you want to delete this?</h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="a_confirm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="a_close">No</button>
            </div>
        </div>
      
    </div>
</div>

<!-- Modal for update-->
<div class="modal fade" id="announcement_warn" role="dialog">
    <div class="modal-dialog">
        
      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Announcement</h4>
            </div>
            <div class="modal-body">
                <h2>Are you sure you want to update this?</h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="e_confirm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="e_close">No</button>
            </div>
        </div>
      
    </div>
</div>