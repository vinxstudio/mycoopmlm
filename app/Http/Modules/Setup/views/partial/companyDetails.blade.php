<h4 class="mt-30">Company details</h4>
<div class="form-group">
    <div class="input-icon mb-15">
        {{ validationError($errors, 'companyName') }}
        <i class="fa fa-bank"></i>
        <input class="form-control" placeholder="Name" id="companyName" name="companyName" value="{{ old('companyName', SystemSettings('name')) }}" type="text">
    </div>
    <div class="form-group">
        <div class="input-icon">
            {{ validationError($errors, 'phone') }}
            <i class="fa fa-phone"></i>
            <input class="form-control" placeholder="Phone" id="phone" value="{{ old('phone', SystemSettings('phone')) }}" type="text" name="phone">
        </div>
    </div>

</div>
<div class="form-group">
    <div class="input-icon">
        {{ validationError($errors, 'address') }}
        <i class="fa fa-home"></i>
        <textarea class="form-control" placeholder="Address" id="address" name="address" rows="10">{{ old('address', SystemSettings('address')) }}</textarea>
    </div>
</div>
<a href="#" class="next-step pull-left btn btn-success" data-target="#tab1-1"><i class="fa fa-arrow-left"></i> Back</a>
<a href="#" class="next-step pull-right btn btn-primary" data-target="#tab1-3">Next <i class="fa fa-arrow-right"></i></a>