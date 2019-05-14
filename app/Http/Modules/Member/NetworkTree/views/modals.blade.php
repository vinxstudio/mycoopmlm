 <div id="message_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title">Error!</h4>
          </div>
          <div class="modal-body">
              <h3 class="message"></h3>
          </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal">
                  Close
              </button>
          </div>
      </div>
  </div>
</div>

 <div id="warning_modal" class="modal fade" role="dialog" style="z-index:9999;">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title">Error!</h4>
          </div>
          <div class="modal-body">
              <h3 class="message"></h3>
          </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-warning" id="btn_yes">
                  Yes
              </button>
              <button type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
              </button>
          </div>
      </div>
  </div>
</div>


<div id="upgrade_modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Upgrade Account</h4>
      </div>
      <div class="modal-body">
        <form id="upgrade_form" action="upgrade/{account_id}">
          <input type="hidden" name="_token" value="{{ csrf_token(); }}">
          <h4 class="text-danger" id="error_message"></h4>
          <div class="row">
            <input type="hidden" name="user_id" class="form-control" id="user_id" value="" readonly>
            <!--<div class="col-md-12 form-group">
              <label class="form-label">User ID.</label>
              <input type="text" name="account_name" class="form-control" id="account_name">
            </div>-->
            <div class="col-md-12 form-group">
              <label class="form-label">Enter Account ID.</label>
              <input type="text" name="account_id" class="form-control" id="account_id">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="form-label">Enter Activation Code</label>
              <input type="text" name="activation_code" class="form-control" id="activation_code">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success form-control" id="upgrade_submit">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="activate_modal" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="activation_close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Activate Account <span class="text-danger">(Fields with ( * ) are required.)</span></h4> 
      </div>
      <div class="modal-body">
        <div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist" id="myTabs">
            <li role="presentation" class="active"><a href="#account_details" >Account Details</a></li>
            <li role="presentation" id="tab_member"><a href="#member_details" >Member Details</a></li>
            <li role="presentation" id="tab_other"><a href="#other_details" >Other Details</a></li>
          </ul>
          {{Form::open(['class' => 'form-group', 'id' => 'activate_form'])}}
          <!-- Tab panes -->
          <input type="hidden" class="form-control" id="for_username" name="for_username" value="{{ $theUser->username }}">
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="account_details">
                <div class="form-group">
                    <!--<label class="control-label">New Own Account?</label>
                    <select class="form-control" name="own_Account" id="own_Account" disabled>
                        <option value="new account" id="new">Other New Member Account</option>
                        <option value="own account" id="own">Own Account</option>
                    </select>
                    <span class="help-block text-danger" id="error_account_option"></span>-->
                    <input type="hidden" name="own_Account" id="own_Account" value="new account" >
                </div>
                <div class="form-group">
                  <label for="upline_id">Upline ID.</label>
                  <input type="text" class="form-control" id="upline_id" name="upline_id" placeholder="Upline ID." readonly>
                </div>
                <div class="form-group">
                  <label for="upline_name">Upline Name</label>
                  <input type="text" class="form-control" id="upline_name" name="upline_name" placeholder="Upline Name" readonly>
                </div>
                <div class="form-group">
                  <label for="sponsor_id">Sponsor ID.</label><span class="text-danger">*</span>
                  <input type="text" class="form-control" id="sponsor_id" name="sponsor_id" placeholder="Search Sponsor ID....">
                  <!--<div class="input-group">
                    <input type="text" class="form-control" id="sponsor_id" name="sponsor_id" placeholder="Search Sponsor ID....">
                    <span class="input-group-btn">
                      <button class="btn btn-success" type="button" id="btn_search_sponsor">Search</button>
                    </span>
                  </div>--><!-- /input-group -->
                  <span class="help-block text-danger" id="error_sponsor_id"></span>
                </div>
                <div class="form-group">
                  <label for="sponsor_name">Sponsor Name</label><span class="text-danger">*</span>
                  <input type="text" class="form-control" id="sponsor_name" name="sponsor_name" placeholder="Sponsor Name" readonly>
                  <span class="help-block text-danger" id="error_sponsor_name"></span>
                </div>
                <div class="form-group">
                  <label for="account-id">Account ID.</label><span class="text-danger">*</span>
                  <input type="text" class="form-control" id="account-id" name="account_id" placeholder="Account ID.">
                  <span class="help-block text-danger" id="error_account_id"></span>
                </div>
                <div class="form-group">
                  <label for="activation-code">Activation Code</label><span class="text-danger">*</span>
                  <input type="text" class="form-control" id="activation-code" name="activation_code" placeholder="Activation Code">
                  <span class="help-block text-danger" id="error_activation_code"></span>
                </div>
                <div class="form-group">
                  <label for="node">Node Replacement</label>
                  <input type="text" class="form-control text-capitalize" id="node" name="node_placement" placeholder="Node Replacement" readonly>
                </div>
                <div class="form-group">
                  <button class="btn btn-success form-control" type="button" id="nxt_account">Next</button>
                  <button class="btn btn-success form-control hidden" type="button" id="submit_activation">SUBMIT ACTIVATION</button>
                </div>
            </div> <!-- account details -->
            <div role="tabpanel" class="tab-pane" id="member_details">
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="coop_id">Coop ID.</label><span class="text-danger">*</span>
                    <input type="text" class="form-control text-capitalize" id="coop_id" name="coop_id" placeholder="xxxx-xxxxxxx-x">
                    <span class="help-block text-danger" id="error_coop_id"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="first_name">First Name</label><span class="text-danger">*</span>
                    <input type="text" class="form-control text-capitalize" id="first_name" name="first_name" placeholder="First Name">
                    <span class="help-block text-danger" id="error_first_name"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="middle_name">Middle Name</label><span class="text-danger">*</span>
                    <input type="text" class="form-control text-capitalize" id="middle_name" name="middle_name" placeholder="Middle Name">
                    <span class="help-block text-danger" id="error_middle_name"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="last_name">Last Name</label><span class="text-danger">*</span>
                    <input type="text" class="form-control text-capitalize" id="last_name" name="last_name" placeholder="Last Name">
                    <span class="help-block text-danger" id="error_last_name"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="suffix">Suffix</label>
                    <input type="text" class="form-control text-capitalize" id="suffix" name="suffix" placeholder="Suffix">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="email">Email</label><span class="text-danger">*</span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    <span class="help-block text-danger" id="error_email"></span>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="username">Username</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    <span class="help-block text-danger" id="error_username"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="password">New Password</label><span class="text-danger">*</span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                    <span class="help-block text-danger" id="error_password"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                    <label for="password_confirmation">Confirm Password</label><span class="text-danger">*</span>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                    <span class="help-block text-danger" id="error_confirm_password"></span>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                    <button class="btn btn-success" type="button" id="back_member">BACK</button>
                </div>
                <div class="col-md-6 ">
                    <button class="btn btn-success pull-right" type="button" id="nxt_member">NEXT</button>
                </div>
              </div>
            </div><!-- member details -->
            <div role="tabpanel" class="tab-pane" id="other_details">
                <legend>Address</legend>
                <label>Present Address (Mailing Address)</label>
                <div class="row">
                  <div class="col-md-3 form-group">
                      <label for="present_region">Region</label><span class="text-danger">*</span>
                      <select class="form-control region text-uppercase " name="present_region" id="present_region" data-type="present"></select>
                      <span class="help-block text-danger" id="error_present_region"></span>
                  </div>
                  <div class="col-md-3 form-group">
                      <label for="present_province">Province</label><span class="text-danger">*</span>
                      <select class="form-control province text-uppercase" name="present_province" id="present_province" data-type="present"  disabled="true"></select>
                      <span class="help-block text-danger" id="error_present_province"></span>
                  </div>
                  <div class="col-md-3 form-group">
                      <label for="present_city_mun">City/Municipality</label><span class="text-danger">*</span>
                      <select class="form-control citymun text-uppercase " name="present_city_mun" id="present_city_mun" data-type="present"  disabled="true"></select>
                      <span class="help-block text-danger" id="error_present_city_mun"></span>
                  </div>
                  <div class="col-md-3 form-group">
                      <label for="present_barangay">Barangay</label><span class="text-danger">*</span>
                      <select class="form-control barangay text-uppercase " name="present_barangay" id="present_barangay" data-type="present"  disabled="true"></select>
                      <span class="help-block text-danger" id="error_present_barangay"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="present_zipcode">Zipcode</label>
                    <input type="text" class="form-control" id="present_zipcode" name="present_zipcode" placeholder="Zipcode">
                  </div>
                  <div class="col-md-9 form-group">
                    <label for="present_address">Address Details(House no./Street/BLDG no.)</label>
                    <input type="text" class="form-control text-uppercase" id="present_address" name="present_address" placeholder="House no./Street/Bldg no.">
                  </div>
                </div>
                <label>Provincial Address</label>
                <div class="row">
                  <div class="col-md-3 form-group">
                      <label for="provincial_region">Region</label>
                      <select class="form-control region text-uppercase " name="provincial_region" id="provincial_region" data-type="provincial" data-type="provincial"></select>
                  </div>
                  <div class="col-md-3 form-group">
                      <label for="provincial_province">Province</label>
                      <select class="form-control province text-uppercase " name="provincial_province" id="provincial_province" data-type="provincial"  disabled="true"></select>
                  </div>
                  <div class="col-md-3 form-group">
                      <label for="provincial_city_mun">City/Municipality</label>
                      <select class="form-control citymun text-uppercase " name="provincial_city_mun" id="provincial_city_mun" data-type="provincial"  disabled="true"></select>
                  </div>
                  <div class="col-md-3 form-group">
                      <label for="provincial_barangay ">Barangay</label>
                      <select class="form-control barangay text-uppercase " name="provincial_barangay" id="provincial_barangay" data-type="provincial"  disabled="true"></select>
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-md-3 form-group">
                    <label for="provincial_zipcode">Zipcode</label>
                    <input type="text" class="form-control" id="provincial_zipcode" name="provincial_zipcode" placeholder="Zipcode">
                  </div>
                  <div class="col-md-9 form-group">
                    <label for="provincial_address">Address Details(House no./Street/BLDG no.)</label>
                    <input type="text" class="form-control text-capitalize" id="provincial_address" name="provincial_address" placeholder="House no./Street/Bldg no.">
                  </div>
                </div>
                <legend>Contact Number</legend>
                <label>(No dash (-) or slash(/))</label>
                <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="cel_number">Cellphone Number</label><span class="text-danger">*</span>
                      <input type="text" class="form-control" id="cel_number" name="cel_number" placeholder="Cellphone Number">
                      <span class="help-block text-danger" id="error_cel_number"></span>
                  </div>
                  <div class="col-md-6 form-group">
                      <label for="other_contact">Other Contact Number</label>
                      <input type="text" class="form-control" id="other_contact" name="other_contact" placeholder="Other Contact Number">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4 form-group">
                      <label for="home_tel">Home Tel. Number</label>
                      <input type="text" class="form-control" id="home_tel" name="home_tel" placeholder="Home Tel. Number">
                  </div>
                  <div class="col-md-4 form-group">
                      <label for="spouse_tel">Spouse Tel. Number</label>
                      <input type="text" class="form-control" id="spouse_tel" name="spouse_tel" placeholder="Spouse Tel. Number">
                  </div>
                  <div class="col-md-4 form-group">
                      <label for="province_tel">Province Tel. Number</label>
                      <input type="text" class="form-control" id="province_tel" name="province_tel" placeholder="Province Tel. Number">
                  </div>
                </div>
                <legend>TrueMoney</legend>
                <div class="row">
                  <div class="col-md-12 form-group">
                      <label for="trueMoney">TrueMoney</label><span class="text-danger"> (Don't have Truemoney account? Just enter "000000000000").</span>
                      <input type="text" class="form-control" id="trueMoney" name="true_money" placeholder="TrueMoney" >
                      <span class="help-block text-danger" id="error_true_money"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                      <button class="btn btn-success" type="button" id="back_other">BACK</button>
                  </div>
                  <div class="col-md-6 ">
                      <button class="btn btn-success pull-right" type="button" id="activate_confirm">CONFIRM</button>
                  </div>
                </div>
              </div><!-- other details -->
          </div>
          {{Form::close()}}
        </div>
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal Verification -->
<div id="verify_modal" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="verify_close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Verify Account</h4>
      </div>
      <div class="modal-body">
        <h4 class="text-center text-warning">Please confirm data before submitting information</h4>
        <br>
        <!--<legend>Account Details</legend>-->
        <!--<ul>
          <li>Upline ID.      : <span id="verify_upline_id"></span></li>
          <li>Upline Name     : <span id="verify_upline_name"></span></li>
          <li>Sponsor ID.     : <span id="verify_sponsor_id"></span></li>
          <li>Sponsor Name    : <span id="verify_sponsor_name"></span></li>
          <li>Account ID.     : <span id="verify_account_id"></span></li>
          <li>Activation Code : <span id="verify_activation_code"></span></li>
          <li>Node Placement  : <span id="verify_node_placement"></span></li>
        </ul>-->
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <th colspan="2"><h4>Account Details</h4></th>
            </tr>
            <tr>
                <td>Upline ID.</td>
                <td><span id="verify_upline_id" class="text-uppercase"></span></td>
            </tr>
            <tr>
                <td>Upline Name</td>
                <td><span id="verify_upline_name" class="text-uppercase"></span></td>
            </tr>
            <tr>
                <td>Sponsor ID.</td>
                <td><span id="verify_sponsor_id" class="text-uppercase"></span></td>
            </tr>
            <tr>
                <td>Sponsor Name</td>
                <td><span id="verify_sponsor_name" class="text-uppercase"></span></td>
            </tr>
            <tr>
                <td>Account ID.</td>
                <td><span id="verify_account_id" class="text-uppercase"></span></td>
            </tr>
            <tr>
                <td>Activation Code</td>
                <td><span id="verify_activation_code" class="text-uppercase"></span></td>
            </tr>
            <tr>
                <td>Node Placement</td>
                <td><span id="verify_node_placement" class="text-uppercase"></span></td>
            </tr>
            <tr>
              <th colspan="2"><h4>Member Details</h4></th>
            </tr>
            <tr class="new_details">
                <td>Coop ID.</td>
                <td><span id="verify_coop_id" class="text-uppercase"></span></td>
            </tr>
            <tr class="new_details">
                <td>Full Name</td>
                <td><span id="verify_full_name" class="text-uppercase"></span></td>
            </tr>
            <tr class="new_details">
                <td>Email</td>
                <td><span id="verify_email"></span></td>
            </tr>
            <tr class="new_details">
                <td>Username</td>
                <td><span id="verify_username"></span></td>
            </tr>
            <tr class="new_details">
                <td>Address</td>
                <td><span id="verify_address" class="text-uppercase"></span></td>
            </tr>
            <tr class="new_details">
                <td>Cellphone No.</td>
                <td><span id="verify_cel_no"></span></td>
            </tr>
            <tr class="new_details">
                <td>TrueMoney</td>
                <td><span id="verify_truemoney"></span></td>
            </tr>
            <tr class="old_details">
              <td colspan="2" class="text-center"><h3>Own Account</h3></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="edit_info">EDIT INFORMATION</button>
        <button type="button" class="btn btn-success" id="activation_submit">SUBMIT ACTIVATION</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
