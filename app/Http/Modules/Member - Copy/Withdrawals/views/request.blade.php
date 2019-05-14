@extends('layouts.members')
@section('content')

    <div class="col-md-6 col-xs-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('withdrawal.request') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                {{ Form::open() }}
                <div class="alert alert-info">
                    <p>{{ Lang::get('messages.minimum_withdrawal') }} {{ number_format($company->withdrawalSettings->minimum_amount, 2) }}</p>
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'amount') }}
                    <label class="control-label">{{ Lang::get('labels.amount') }}</label>
                    {{ Form::text('amount', old('amount', $company->withdrawalSettings->minimum_amount), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'bank_name') }}
                    <label class="control-label">{{ Lang::get('labels.bank_name') }}</label>
                    {{ Form::text('bank_name', old('bank_name', $theUser->details->bank_name), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'bank_account_name') }}
                    <label class="control-label">{{ Lang::get('labels.bank_account_name') }}</label>
                    {{ Form::text('bank_account_name', old('bank_account_name', $theUser->details->account_name), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'bank_account_number') }}
                    <label class="control-label">{{ Lang::get('labels.bank_account_number') }}</label>
                    {{ Form::text('bank_account_number', old('bank_account_number', $theUser->details->account_number), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'notes') }}
                    <label class="control-label">{{ Lang::get('labels.notes') }}</label>
                    {{ Form::textarea('notes', old('notes'), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group">
                    {{ Form::button(Lang::get('labels.request'), [
                        'type'=>'submit',
                        'value'=>'request',
                        'name'=>'request',
                        'class'=>'btn btn-primary'
                    ]) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('withdrawal.balance_details') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <td>{{ Lang::get('labels.direct_referral') }}</td>
                        <td>{{ number_format($theUser->referralIncome, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::get('labels.indirect_referral') }}</td>
                        <td>{{ number_format($theUser->pairingIncome, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::get('labels.indirect_sales') }}</td>
                        <td>{{ number_format($theUser->unilevelIncome, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::get('labels.rebates') }}</td>
                        <td>{{ number_format($theUser->rebatesIncome, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::get('labels.withdrawn') }}</td>
                        <td>{{ number_format($theUser->withdrawn, 2) }}</td>
                    </tr>
                    <tr class="success">
                        <td>{{ Lang::get('labels.remaining_balance') }}</td>
                        <td>{{ number_format($theUser->remainingBalance, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@stop