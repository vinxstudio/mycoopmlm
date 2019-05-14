<!-- Modal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Details</h4>
			</div>
			<div class="modal-body">
				{{Form::open()}}
					<div action="form-group">
						<input type="hidden" class="form-control edit_user_id" name="e_member_id" disabled>
						<label for="member_fname">First Name</label>
						<input type="text" class="form-control edit_fname" name="e_member_fname" disabled>
					</div>
					<div action="form-group">
						<label for="member_lname">Last Name</label>
						<input type="text" class="form-control edit_lname" name="e_member_lname" disabled>
					</div>
					<div action="form-group">
						<label for="member_email">Email</label>
						<input type="text" class="form-control edit_email" name="e_member_email" disabled>
					</div>
					<div action="form-group">
						<label for="member_bankname">Bank Name</label>
						<input type="text" class="form-control edit_bankname" name="e_member_bankname" disabled>
					</div>
					<div action="form-group">
						<label for="member_accountname">Account Name</label>
						<input type="text" class="form-control edit_accountname" name="e_member_accountname" disabled>
					</div>
					<div action="form-group">
						<label for="member_accountnumber">Account Number</label>
						<input type="text" class="form-control edit_accountnumber" name="e_member_accountnumber" disabled>
					</div>
					<div action="form-group">
						<label for="member_username">Username</label>
						<input type="text" class="form-control edit_username" name="e_member_username" disabled>
					</div>
					<div action="form-group">
						<div class="form-inline">
							<label for="member_sponsor">
									Sponsor
							</label>
							<input type="text" class="form-control edit_sponsor" name="e_member_sponsor" style="width: 75%;" disabled/>
							<input type="hidden" class="edit_sponsor_id" name="e_member_sponsor_id" />
							<input type="hidden" class="edit_user_account_id" name="e_member_user_account_id"/>
							<button type="button" class="btn btn-success e_sponsor_btn_change pull-right">Change Sponsor</button>
							<div class="clearfix"></div>
						</div>
					</div>

					{{-- <div class="form-group">
						<label for="member_sponsor">
							Sponsor
						</label>
						<input type="text" class="form-control edit_sponsor pull-right" name="e_member_sponsor" style="display: inline !important;" disabled/>
						<input type="hidden" class="edit_sponsor_id" name="e_member_sponsor_id" />
						<input type="hidden" class="edit_sponsor_isEdit" name="e_member_sponsor_forEdit" value="false"/>

						<button type="button" class="btn btn-success pull-right e_sponsor_btn_change">Change Sponsor</button>
					</div> --}}
					<div action="form-group">
						<label for="member_password1">Change Password</label>
						<input type="password" class="form-control " id="password" name="password" placeholder="New Password">
						<span class="help-block text-danger" id="error_password"></span>
					</div>
					<div action="form-group">
						<label for="member_password2">Confirm Password</label>
						<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
						<span class="help-block text-danger" id="error_confirm_password"></span>
					</div>
				{{Form::close()}}
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success update" id="btn-update">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close">Close</button>
			</div>
		</div>
	</div>
</div>