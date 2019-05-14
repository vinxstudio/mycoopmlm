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
                <!-- <div class="alert alert-info">
                    <p>{{ Lang::get('messages.minimum_withdrawal') }} {{ number_format($company->withdrawalSettings->minimum_amount, 2) }}</p>
                </div> -->
                <div class="form-group savings">
                    {{ validationError($errors, 'savings') }}
                    <label class="control-label"> Savings </label>
                    {{ Form::text('savings', old('savings', 0), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group shared_capital">
                    {{ validationError($errors, 'amount') }}
                    <label class="control-label"> Capital Share </label>
                    {{ Form::text('shared_capital', old('shared_capital', 0), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                 <div class="form-group maintenance">
                    {{ validationError($errors, 'savings') }}
                    <label class="control-label"> Maintenance </label>
                    {{ Form::text('maintenance', old('maintenance', 0), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group">
                    <?php
                        $list = array('Truemoney');
                    ?>
                    {{ validationError($errors, 'transaction_type') }}
                    <label class="control-label">Select Transation Type</label>
                    {{ Form::select('transaction_type',$list, old('transaction_type',0), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group amount">
                    {{ validationError($errors, 'amount') }}
                    <label class="control-label">{{ Lang::get('labels.amount') }}</label>
                    {{ Form::text('amount', old('amount', $company->withdrawalSettings->minimum_amount), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group b_name">
                    {{ validationError($errors, 'bank_name') }}
                    <label class="control-label">{{ Lang::get('labels.bank_name') }}</label>
                    {{ Form::text('bank_name', old('bank_name', $theUser->details->bank_name), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group b_acc_name">
                    {{ validationError($errors, 'bank_account_name') }}
                    <label class="control-label">{{ Lang::get('labels.bank_account_name') }}</label>
                    {{ Form::text('bank_account_name', old('bank_account_name', $theUser->details->account_name), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group b_acc_number">
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
                        {{-- <td>{{ Lang::get('labels.direct_referral') }}</td> --}}
                        <td>Advance Dividend</td>
                        <td>{{ number_format($theUser->referralIncome, 2) }}</td>
                    </tr>
                    <tr>
                        {{-- <td>{{ Lang::get('labels.indirect_referral') }}</td> --}}
                        <td>Efficiency Bonus</td>
                        <td>{{ number_format($theUser->pairingIncome, 2) }}</td>
                    </tr>
                    <!-- <tr>
                        <td>{{ Lang::get('labels.indirect_sales') }}</td>
                        <td>{{ number_format($theUser->unilevelIncome, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::get('labels.rebates') }}</td>
                        <td>{{ number_format($theUser->rebatesIncome, 2) }}</td>
                    </tr> -->
                    <tr>
                        <td>{{ Lang::get('labels.savings') }}</td>
                        <td>{{ number_format($theUser->savings, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::get('labels.shared_capital') }}</td>
                        <td>{{ number_format($theUser->sharedCapital, 2) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::get('labels.maintenance') }} - CBU</td>
                        <td>{{ number_format($theUser->maintenance, 2) }}</td>
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
<script>
        $(document).ready(function(){
            var t_type = $('select[name="transaction_type"]').val();
            action(t_type);

            $('input[name="bank_name"]').attr('readonly', true);
            $('input[name="bank_account_name"]').attr('readonly', true);
            // $('input[name="bank_account_number"]').attr('readonly', true);
                        
            $('select[name="transaction_type"]').on('change', function(){
                var t_type = $(this).val();
                action(t_type);
            });

            function action(t_type){
                switch(t_type){
                    case '3':
                        $('.amount').hide();
                        $('.b_name').hide();
                        $('.b_acc_name').hide();
                        $('.b_acc_number').hide();
                        break;
                    case '1':
                         // disable input box
                        $('input[name="bank_name"]').val('');
                        $('input[name="bank_account_name"]').val('');
                        $('input[name="bank_account_number"]').val('');

                         // get banck account
                        $('input[name="bank_name"]').val('<?php echo $details['bank_name']?>');
                        $('input[name="bank_account_name"]').val('<?php echo $details['bank_acc_name']?>');
                        $('input[name="bank_account_number"]').val('<?php echo $details['bank_acc_num']?>');

                        $('.amount').show();
                        $('.b_name').show();
                        $('.b_acc_name').show();
                        $('.b_acc_number').show();

                        // $('input[name="bank_name"]').attr('disabled', true);
                        // $('input[name="bank_account_name"]').attr('disabled', true);
                        // $('input[name="bank_account_number"]').attr('disabled', true);
                    break;

                    case '2':
                         $('input[name="bank_name"]').val('');
                        $('input[name="bank_account_name"]').val('');
                        $('input[name="bank_account_number"]').val('');
                        $('.amount').show();
                        $('input[name="bank_name"]').val('Cheque');
                        $('.b_name').hide();
                        $('.b_acc_name').hide();
                        $('.b_acc_number').hide();
                    break;

                    case '0':
                        // get truemony account
                        $('input[name="bank_name"]').val('Truemoney');
                        $('input[name="bank_account_number"]').val('<?php echo $details['truemoney']?>');
                        $('.b_acc_name').hide();
                        $('.b_name').show();
                        $('.b_acc_number').show();
                        $('.amount').show();
                        // disable input box
                        // $('input[name="bank_name"]').attr('disabled', true);
                        // $('input[name="bank_account_number"]').attr('disabled', true);
                        break;

                    default:
                        $('.b_name').show();
                        $('.b_acc_name').show();
                        $('.b_acc_number').show();
                        $('.amount').show();
                        //$('input[name="bank_name"]').attr('disabled', false);
                        //$('input[name="bank_account_name"]').attr('disabled', false);
                        //$('input[name="bank_account_number"]').attr('disabled', false);
                    break;

                }
            }
        });


        $(function() {
            $( "#from_date" ).datetimepicker({
                format:'YYYY-MM-DD 06:00:01',
            });
        });

        $(function() {
            $( "#to_date" ).datetimepicker({
                format:'YYYY-MM-DD 05:59:59',
            });
        });

</script>   
@stop
