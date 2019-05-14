<div class="row">
    <div class="col-md-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ Lang::get('pairing.settings') }}<code></code></h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding" style="display: block;">

                {{ Form::open([ 'class'=>'form-inline' ]) }}
				
                <div class="form-body">
				 @foreach($membership as $packages)
					<div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'membership_type_name') }}
                        <label class="col-sm-10 control-label">{{ $packages->membership_type_name }}</label>
                        <div class="col-sm-10">
                            <input type="text" size="15" class="form-control" name="membership_description[]" value="{{ $packages->membership_description }}" readonly>
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'pairing_income') }}
                        <label class="col-sm-12 control-label">{{ Lang::get('pairing.income') }}</label>
                        <div class="col-sm-12">
                            <input type="text" size="10" class="form-control" name="pairing_income[]" value="{{ $packages->pairing_income }}">
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'referral_income') }}
                        <label class="col-sm-10 control-label">{{ Lang::get('pairing.referral_income') }}</label>
                        <div class="col-sm-10">
                            <input type="text" size="10" class="form-control" name="referral_income[]" value="{{ $packages->referral_income }}">
                        </div>
                    </div>
					<div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'points_value') }}
                        <label class="col-sm-10 control-label">Points Value</label>
                        <div class="col-sm-10">
                            <input type="text" size="10" class="form-control" name="points_value[]" value="{{ $packages->points_value }}">
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-3">
                        {{ validationError($errors, 'max_pair') }}
                        <label class="col-sm-12 control-label">{{ Lang::get('pairing.max_pair') }}</label>
                        <div class="col-sm-12">
                            <input type="text" size="10" class="form-control" name="max_pairing[]" value="{{ $packages->max_pairing }}">
                        </div>
                    </div>
				
					 <div class="clearfix"></div>
					<div>
					
						</br>
						
					</div>
					@endforeach
					
					<!--div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'pairing_income') }}
                        <label class="col-sm-10 control-label">Package B</label>
                        <div class="col-sm-10">
                            <input type="text" size="10" class="form-control" name="pairing_income" value="Package B" readonly>
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'pairing_income') }}
                        <label class="col-sm-12 control-label">{{ Lang::get('pairing.income') }}</label>
                        <div class="col-sm-12">
                            <input type="text" size="10" class="form-control" name="pairing_income" value="200">
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-3">
                        {{ validationError($errors, 'referral_income') }}
                        <label class="col-sm-12 control-label">{{ Lang::get('pairing.referral_income') }}</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="referral_income" value="{{ old('max_pair', $company->referral_income) }}">
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-3">
                        {{ validationError($errors, 'max_pair') }}
                        <label class="col-sm-12 control-label">{{ Lang::get('pairing.max_pair') }}</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="max_pair" value="7">
                        </div>
                    </div>
                   
					
					<div class="clearfix"></div>
					</br>
				
					
					<div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'pairing_income') }}
                        <label class="col-sm-10 control-label">Package C</label>
                        <div class="col-sm-10">
                            <input type="text" size="10" class="form-control" name="pairing_income" value="Package C" readonly>
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'pairing_income') }}
                        <label class="col-sm-12 control-label">{{ Lang::get('pairing.income') }}</label>
                        <div class="col-sm-12">
                            <input type="text" size="10" class="form-control" name="pairing_income" value="300">
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-3">
                        {{ validationError($errors, 'referral_income') }}
                        <label class="col-sm-12 control-label">{{ Lang::get('pairing.referral_income') }}</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="referral_income" value="{{ old('max_pair', $company->referral_income) }}">
                        </div>
                    </div>
                    <div class="form-group pull-left col-md-3">
                        {{ validationError($errors, 'max_pair') }}
                        <label class="col-sm-12 control-label">{{ Lang::get('pairing.max_pair') }}</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="max_pair" value="{{ old('max_pair', $company->daily_max_pair) }}">
                        </div>
                    </div-->
                   
					
					<div class="clearfix"></div>
					</br>
					<hr>
					
					 <div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'max_pair') }}
                        <label class="col-sm-10 control-label">First Start Time </label>
                        <div class="col-sm-10">
                            <input type="text" size="10" class="form-control" name="first_start_time" value="{{ $company->first_start_time }}">  
							
                        </div>
                    </div>
					
					 <div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'max_pair') }}
                        <label class="col-sm-10 control-label">First Cut Off Time </label>
                        <div class="col-sm-10">
                            <input type="text" size="10" class="form-control" name="first_cut_off_time" value="{{ $company->first_cut_off_time }}">  
							
                        </div>
                    </div>
					
					 <div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'max_pair') }}
                        <label class="col-sm-12 control-label">Second Start Time </label>
                        <div class="col-sm-10">
                            <input type="text" size="10" class="form-control" name="second_start_time" value="{{ $company->second_start_time }}">  
							
                        </div>
                    </div>
					
					 <div class="form-group pull-left col-md-2">
                        {{ validationError($errors, 'max_pair') }}
                        <label class="col-sm-12 control-label">Second Cut Off Time </label>
                        <div class="col-sm-10">
                            <input type="text" size="10" class="form-control" name="second_cut_off_time" value="{{ $company->second_cut_off_time }}">  
							
                        </div>
                    </div>
					
					
                    <div class="form-group pull-left col-md-3">
                        <label class="col-sm-10 control-label">{{ Lang::get('pairing.flush_out') }}</label>
                        <div class="col-sm-10">
                            {{ Form::select('flush_out', [
                                '0'=>Lang::get('pairing.enable'),
                                '1'=>Lang::get('pairing.disable')
                            ], old('flush_out', $company->enable_flush_out), [
                                'class'=>'form-control chosen-select'
                            ]) }}

                        </div>
					
                    </div>
					
					 <div class="clearfix"></div>
					 <br>
					
                    <div class="form-group col-xs-12 col-md-12">
                        <button type="submit" name="save_settings" value="save_settings" class="btn btn-success">{{ Lang::get('labels.save') }}</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>

</div>