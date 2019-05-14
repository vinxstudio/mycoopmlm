@extends('layouts.master')

@section('content')
    <div class="col-md-6">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ Lang::get('company.details') }}</h3>
                </div>
                <div class="pull-right">
                    <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse" data-original-title="" title=""><i class="fa fa-angle-up"></i></button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">

                {{ Form::open([
                    'class'=>'form-horizontal'
                ]) }}
                    <div class="form-body">
                        <div class="form-group no-margin">
                            <div class="row">
                                <div class="col-md-6">
                                    {{ validationError($errors, 'companyName') }}
                                    <input type="text" class="form-control mb-15" placeholder="Company Name" value="{{ old('companyName', $company->name) }}" name="companyName">
                                </div>
                                <div class="col-md-6">
                                    {{ validationError($errors, 'phone') }}
                                    <input type="text" class="form-control mb-15" placeholder="Phone" name="phone" value="{{ old('phone', $company->phone) }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'programName') }}
                            <input type="text" class="form-control" placeholder="Program Name" name="programName" value="{{ old('programName', $company->app_name) }}">
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'address') }}
                            <textarea class="form-control" rows="5" placeholder="Address" name="address">{{ old('address', $company->address) }}</textarea>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" name="save_details" value="save_details" class="btn btn-success">Submit</button>
                    </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ Lang::get('company.bank') }}</h3>
                </div>
                <div class="pull-right">
                    <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse" data-original-title="" title=""><i class="fa fa-angle-up"></i></button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">

                {{ Form::open([
                    'class'=>'form-horizontal'
                ]) }}
                    <div class="form-body">
                        <div class="form-group no-margin">
                            <div class="row">
                                <div class="col-md-6">
                                    {{ validationError($errors, 'bankName') }}
                                    {{ Form::text('bankName', old('bankName', $bank->bank_name), [
                                        'class'=>'form-control mb-15',
                                        'placeholder'=>Lang::get('company.bank_name')
                                    ]) }}
                                </div>
                                <div class="col-md-6">
                                    {{ validationError($errors, 'bankAccountName') }}
                                    {{ Form::text('bankAccountName', old('bankAccountName', $bank->account_name), [
                                        'class'=>'form-control mb-15',
                                        'placeholder'=>Lang::get('company.bank_account_name')
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'bankAccountNumber') }}
                            {{ Form::text('bankAccountNumber', old('bankAccountNumber', $bank->account_number), [
                                'class'=>'form-control mb-15',
                                'placeholder'=>Lang::get('company.bank_account_number')
                            ]) }}
                        </div>
                        <div class="form-group">
                            {{ validationError($errors, 'notes') }}
                            {{ Form::text('notes', old('notes', $bank->notes), [
                                'class'=>'form-control mb-15',
                                'placeholder'=>Lang::get('company.notes')
                            ]) }}
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-xs-12 row">
                                <label class="control-label">{{ Lang::get('labels.currency') }}</label>
                                {{ Form::select('currency', $currencies, old('currency', config('money.currency')), [
                                    'class'=>'form-control chosen'
                                ]) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" name="save_bank" value="save_details" class="btn btn-success">Submit</button>
                    </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
@stop