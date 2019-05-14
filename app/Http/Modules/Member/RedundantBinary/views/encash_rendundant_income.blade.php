@extends('layouts.members')
@section('content')
    <div class="col-md-6 col-xs-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">Request Withdrawal</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                {{ Form::open(['url' => 'member/encash-redundant-form', 'method' => 'POST']) }}
                <p>
                    Minimum withdrawal is 
                    <span>
                        {{ number_format($minimun_withdrawal, 2) }}
                    </span>
                </p>
                <p>
                    Note : 
                    <i>
                        The 600 &#8369; is for the products by auto deduction.
                    </i>
                </p>
                @if(session()->has('message'))
                    <div class="alert @if(session('status') == 'success') alert-success @elseif(session('status') == 'error') alert-danger @endif">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="form-group">
                    <?php
                        $list = array('Truemoney');
                    ?>
                    {{ validationError($errors, 'transaction_type') }}
                    <label class="control-label">Select Transation Type</label>
                    {{ Form::select('transaction_type',$list, old('transaction_type', 0), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group amount">
                    {{ validationError($errors, 'amount') }}
                    <label class="control-label">{{ Lang::get('labels.amount') }}</label>
                    {{ Form::text('amount', old('amount', 0), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group b_name">
                    {{ validationError($errors, 'bank_name') }}
                    <label class="control-label">Bank Name</label>
                    {{ Form::text('bank_name', old('bank_name', $theUser->details->bank_name), [
                        'class'=>'form-control'
                    ]) }}
                </div>
                <div class="form-group b_acc_number">
                    {{ validationError($errors, 'bank_account_number') }}
                    <label class="control-label">Account Number</label>
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
                <h3 class="panel-title">Balance Details</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <td>
                            Redundant Binary Income
                        </td>
                        <td>
                            {{ number_format($rend_income, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Commision Withdrawn</td>
                        <td>{{ number_format($commision_withdrawn, 2) }}</td>
                    </tr>
                    <tr class="list_two">
                        <td>
                            Withdrawn Ammount
                        </td>
                        <td>
                            {{ number_format($withdrawn_amount, 2) }}
                        </td>
                    </tr>
                    <tr class="list_two">
                        <td>
                            Deduction Ammount
                        </td>
                        <td>
                            {{ number_format($deduction_amount, 2) }}
                        </td>
                    </tr>
                    <tr class="success">
                        <td>Remaining Balance</td>
                        <td>{{ number_format($remaining_balance, 2) }}</td>
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
                        $('input[name="bank_name"]').val('');
                        $('input[name="bank_account_name"]').val('');
                        $('input[name="bank_account_number"]').val('');

                        $('input[name="bank_name"]').val('<?php echo $details['bank_name']?>');
                        $('input[name="bank_account_name"]').val('<?php echo $details['bank_acc_name']?>');
                        $('input[name="bank_account_number"]').val('<?php echo $details['bank_acc_num']?>');

                        $('.amount').show();
                        $('.b_name').show();
                        $('.b_acc_name').show();
                        $('.b_acc_number').show();

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
                        $('input[name="bank_name"]').val('Truemoney');
                        $('input[name="bank_account_number"]').val('<?php echo $details['truemoney']?>');
                        $('.b_acc_name').hide();
                        $('.b_name').show();
                        $('.b_acc_number').show();
                        $('.amount').show();;
                        break;

                    default:
                        $('.b_name').show();
                        $('.b_acc_name').show();
                        $('.b_acc_number').show();
                        $('.amount').show();
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
<style>

    tr.list_two td{
        font-size: .95em;
    }
    tr.list_two td:first-child{
        padding-left: 25px !important;
    }

</style>
@stop
