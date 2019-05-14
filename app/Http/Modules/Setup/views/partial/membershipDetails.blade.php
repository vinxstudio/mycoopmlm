<h4 class="mt-30">Membership Settings</h4>
<div class="form-group">
    <div class="input-icon mb-15">
        {{ validationError($errors, 'businessName') }}
        <label class="control-label">Business Name</label>
        <i class="fa fa-database"></i>
        <input class="form-control" placeholder="Business Name" id="businessName" name="businessName" value="{{ old('businessName', SystemSettings('app_name')) }}" type="text">
    </div>
    <div class="input-icon mb-15">
        {{ validationError($errors, 'entryFee') }}
        <label class="control-label">Entry Fee</label>
        <i class="fa fa-key"></i>
        <input class="form-control" placeholder="Entry Fee" id="entryFee" value="{{ old('registrationFee', $membership->entry_fee) }}" name="entryFee" type="text">
    </div>
    <div class="input-icon mb-15">
        {{ validationError($errors, 'globalPool') }}
        <label class="control-label">Global Pool</label>
        <i class="fa fa-globe"></i>
        <input class="form-control" placeholder="Global Pool" id="globalPool" value="{{ old('globalPool', $membership->global_pool) }}" name="globalPool" type="number">
    </div>
    <div class="input-icon mb-15">
        {{ validationError($errors, 'maximumPairingPerDay') }}
        <label class="control-label">Max Daily Pairing</label>
        <i class="fa fa-link"></i>
        <input class="form-control" placeholder="Maximum Daily Pairing" id="maxPair" value="{{ old('maximumPairingPerDay', $membership->max_pairing) }}" name="maxPair" type="number">
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Compensation Settings</label>
        <div class="col-md-8">
            <?php $old = old('enable_voucher', ($membership->enable_voucher) ? 'on' : null);
                $checked = ($old == 'on') ? 'checked="checked"' : null
            ?>
            <div class="ckbox ckbox-theme rounded">
                <input id="voucher" name="enable_voucher" {{ $checked }} type="checkbox">
                <label for="voucher">Enable Voucher</label>
            </div>

        </div>
    </div>
</div>
<a href="#" class="next-step pull-left btn btn-success" data-target="#tab1-2"><i class="fa fa-arrow-left"></i> Back</a>
<a href="#" class="next-step pull-right btn btn-primary" data-target="#tab1-4">Next <i class="fa fa-arrow-right"></i></a>
