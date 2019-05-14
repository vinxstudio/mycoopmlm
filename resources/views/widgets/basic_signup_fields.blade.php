<div class="form-group">
    {{ validationError($errors, 'first_name') }}
    <label class="control-label">{{ Lang::get('members.first_name') }}</label>
    <input type="text" name="first_name" placeholder="{{ Lang::get('members.first_name') }}" value="{{ old('first_name', isset($user->details->first_name) ? $user->details->first_name : null ) }}" class="form-control" >
</div>
<div class="form-group">
    {{ validationError($errors, 'middle_name') }}
    <label class="control-label">Middle Name</label>
    <input type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name', isset($user->details->middle_name) ? $user->details->middle_name : null) }}" class="form-control" >
</div>
<div class="form-group">
    {{ validationError($errors, 'last_name') }}
    <label class="control-label">{{ Lang::get('members.last_name') }}</label>
    <input type="text" name="last_name" placeholder="{{ Lang::get('members.last_name') }}" value="{{ old('last_name', isset($user->details->last_name) ? $user->details->last_name : null) }}" class="form-control" >
</div>
<div class="form-group">
    {{ validationError($errors, 'email') }}
    <label class="control-label">{{ Lang::get('members.email') }}</label>
    <input type="text" name="email" placeholder="{{ Lang::get('members.email') }}" value="{{ old('email', isset($user->details->email) ? $user->details->email : null) }}" class="form-control" >
</div>
<div class="form-group" style="display: none;">
    {{ validationError($errors, 'bank_name') }}
    <label class="control-label">{{ Lang::get('members.bank_name') }}</label>
    <input type="hidden" name="bank_name" placeholder="{{ Lang::get('members.bank_name') }}" value="{{ old('bank_name', isset($user->details->bank_name) ? $user->details->bank_name : 'Bank Name') }}" class="form-control" >
</div>
<div class="form-group" style="display: none;">
    {{ validationError($errors, 'bank_account_name') }}
    <label class="control-label">{{ Lang::get('members.bank_account_name') }}</label>
    <input type="hidden" name="bank_account_name" placeholder="{{ Lang::get('members.bank_account_name') }}" value="{{ old('bank_account_name', isset($user->details->account_name) ? $user->details->account_name : '00000000000') }}" class="form-control" >
</div>
<div class="form-group" style="display: none;">
    {{ validationError($errors, 'bank_account_number') }}
    <label class="control-label">{{ Lang::get('members.bank_account_number') }}</label>
    <input type="hidden" name="bank_account_number" placeholder="{{ Lang::get('members.bank_account_number') }}" value="{{ old('bank_account_number', isset($user->details->account_number) ? $user->details->account_number : '00000000000') }}" class="form-control" >
</div>
<div class="form-group">
    {{ validationError($errors, 'username') }}
    <label class="control-label">{{ Lang::get('members.username') }}</label>
    <input type="text" name="username" placeholder="{{ Lang::get('members.username') }}" value="{{ old('username', isset($user->username) ? $user->username : null) }}" class="form-control" >
</div>
<div class="form-group">
    {{ validationError($errors, 'password') }}
    <label class="control-label">{{ ($id > 0) ? Lang::get('members.change_password') : Lang::get('members.new_password') }}</label>
    <input type="password" name="password" placeholder="{{ ($id > 0) ? Lang::get('members.change_password') : Lang::get('members.new_password') }}" value="" class="form-control">
</div>
<div class="form-group">
    {{ validationError($errors, 'password_confirm') }}
    <label class="control-label">{{ Lang::get('members.confirm_new_password') }}</label>
    <input type="password" name="password_confirm" placeholder="{{ Lang::get('members.confirm_new_password') }}" value="" class="form-control">
</div>