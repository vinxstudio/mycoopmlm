<!-- Modal -->
<div class="modal fade" id="generateCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Verify Registration Account</h4>
      </div>
      <div class="modal-body">
        <h3>Please confirm data before submitting information</h3><br>
         <ul>
          <!-- <li>Account ID : <label id='m_account_id'></label></li> -->
          <legend>Member Details</legend>
          <div id="new_acc">
            <li>Full Name : <label id='c_fullname' style="font-weight: bold;"></label></li>
            <li>Email : <label id='c_email' style="font-weight: bold;"></label></li>
            <li>Username : <label id='c_username' style="font-weight: bold;"></label></li>
          </div>
          <div id="own_acc">
            <h4>Own Account</h4>
          </div>
          <br>
          <legend>Upline Details</legend>
          <li>Upline Name : <label id='c_upline_name' style="font-weight: bold;"></label></li>
          <li>Upline ID : <label id='c_upline_id' style="font-weight: bold;"></label></li>
          <br>
          <legend>Sponsor Details</legend>
          <li>Sponsor Name : <label id='c_sponsor_name' style="font-weight: bold;"></label></li>
          <li>Sponsor ID : <label id='c_sponsor_id' style="font-weight: bold;"></label></li>
          <br>
          <legend>Account Details</legend>
          <li>Account ID : <label id='c_account_id' style="font-weight: bold;"></label></li>
          <li>Activation Code : <label id='c_activation_code' style="font-weight: bold;"></label></li>

          <li>Placement : <label id='c_placement' style="font-weight: bold;"></label></li>

        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="submit-form" class="btn btn-primary">Submit Registration</button>
      </div>
    </div>
  </div>
</div>