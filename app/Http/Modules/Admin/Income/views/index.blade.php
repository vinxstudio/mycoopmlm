@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-theme rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ Lang::get('income.fees_and_bonus') }}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body" style="display: block;">
                    <br/>
                    {{ Form::open([ 'class'=>'form-inline' ]) }}
                    <div class="form-body">
					   @foreach($membership as $packages)
						 <div class="form-group">
                            {{ validationError($errors, 'package_name') }}
                            <label class="col-sm-12 control-label">Membership Type / Package Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="package_name[]" value="{{ $packages->membership_type_name }} ">
                            </div>
                        </div>
						 <div class="form-group">
                            {{ validationError($errors, 'package_description') }}
                            <label class="col-sm-12 control-label">Membership Type / Package Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="package_description[]" value="{{ $packages->membership_description }}">
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'entry_fee') }}
                            <label class="col-sm-12 control-label">{{ Lang::get('income.entry_fee') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="entry_fee[]" value="{{ $packages->entry_fee }}">
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'money_pot_amount') }}
                            <label class="col-sm-12 control-label">{{ Lang::get('income.money_pot') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="money_pot[]" value="{{ $packages->money_pot }}">
                                <br/>
                                <small>{{ Lang::get('income.money_pot_description') }}</small>

                            </div>
                        </div>
					  @endforeach
						
						<!--/br>
						<hr>
						
						 <div class="form-group">
                            {{ validationError($errors, 'entry_fee') }}
                            <label class="col-sm-12 control-label">Membership Type / Package Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="entry_fee" value="Package B">
                            </div>
                        </div>
						 <div class="form-group">
                            {{ validationError($errors, 'entry_fee') }}
                            <label class="col-sm-12 control-label">Membership Type / Package Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="entry_fee" value="Package B Description">
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'entry_fee') }}
                            <label class="col-sm-12 control-label">{{ Lang::get('income.entry_fee') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="entry_fee" value="{{ old('entry_fee', $company->entry_fee) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'money_pot_amount') }}
                            <label class="col-sm-12 control-label">{{ Lang::get('income.money_pot') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="money_pot_amount" value="{{ old('money_pot_amount', $company->money_pot) }}">
                                <br/>
                                <small>{{ Lang::get('income.money_pot_description') }}</small>

                            </div>
                        </div>
						</br>
						<hr>
						
						 <div class="form-group">
                            {{ validationError($errors, 'entry_fee') }}
                            <label class="col-sm-12 control-label">Membership Type / Package Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="entry_fee" value="Package C">
                            </div>
                        </div>
						 <div class="form-group">
                            {{ validationError($errors, 'entry_fee') }}
                            <label class="col-sm-12 control-label">Membership Type / Package Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="entry_fee" value="Package C Description">
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'entry_fee') }}
                            <label class="col-sm-12 control-label">{{ Lang::get('income.entry_fee') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="entry_fee" value="{{ old('entry_fee', $company->entry_fee) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'money_pot_amount') }}
                            <label class="col-sm-12 control-label">{{ Lang::get('income.money_pot') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="money_pot_amount" value="{{ old('money_pot_amount', $company->money_pot) }}">
                                <br/>
                                <small>{{ Lang::get('income.money_pot_description') }}</small>

                            </div>
                        </div-->
						
						
						
					  
                        <div class="form-group">
                            <label for=""></label><br/>
                            <button type="submit" name="save_entry_fee" value="save_entry_fee" class="btn btn-success">{{ Lang::get('labels.save') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-theme rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ Lang::get('income.account_maintenance') }}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <p>{{ Lang::get('income.maintenance_description') }}</p>
                    {{ Form::open() }}
                    <div class="form-group">
                        <label class="control-label">{{ Lang::get('income.minimum_purchase') }}</label>
                        {{ Form::text('minimum_purchase', old('minimum_purchase', $company->minimum_product_purchase), [
                            'class'=>'form-control'
                        ]) }}
                        <span class="error-message">{{ Lang::get('income.if_deactivate') }}</span>
                    </div>
                    <div class="form-group">
                        {{ Form::button(Lang::get('labels.save'), [
                            'type'=>'submit',
                            'value'=>'save_maintenance',
                            'name'=>'save_maintenance',
                            'class'=>'btn btn-primary'
                        ]); }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </div>

@stop