@extends('layouts.members')
@section('content')
    @if ($slip == null)
    <div class="col-md-6">
        <div class="panel panel-info rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-paypal"></i> {{ Lang::get('payment.paypal') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <center>
                        <h2><b>{{ config('money.currency_symbol') }} {{ number_format($member->entry_fee, 2) }}</b></h2>
                        <a class="btn btn-info btn-lg" href="{{ url('member/payment/paypal-payment') }}"><i class="fa fa-paypal"></i> {{ Lang::get('payment.pay_now') }}</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-6">
        <div class="panel panel-success rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bank"></i> {{ Lang::get('payment.deposit') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <table class="table">
                        <tr>
                            <td>Bank Name : {{ $bank->name }}</td>
                        </tr>
                        <tr>
                            <td>Account Name : {{ $bank->account_name }}</td>
                        </tr>
                        <tr>
                            <td>Account Number : {{ $bank->account_number }}</td>
                        </tr>
                        <tr>
                            <td>{{ $bank->notes }}</td>
                        </tr>
                    </table>
                    @if ($slip == null)
                    {{ Form::open([
                        'url'=>url('member/payment/pay-now'),
                        'files'=>true
                    ]) }}
                    <center>
                        <h2><b>{{ config('money.currency_symbol') }} {{ number_format($member->entry_fee, 2) }}</b></h2>
                        <div class="form-group">
                            <div class="fileinput {{ (isset($reward->id) and file_exists($reward->photo)) ? 'fileinput-exist' : 'fileinput-new' }}" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                    @if (isset($reward->id) and file_exists($reward->photo))
                                        <img src="{{ url($reward->photo) }}" alt=""/>
                                    @endif
                                </div>
                                <div>
                                    <span class="btn btn-primary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="photo"></span>
                                    <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="deposit" value="deposit" class="btn btn-success btn-lg"><i class="fa fa-bank"></i> {{ Lang::get('payment.upload') }}</button>
                    </center>
                    {{ Form::close() }}
                    @else
                        <center>
                            <div class="fileinput fileinput-exist" data-provides="fileinput">
                                <div class="fileinput-preview fileinput-exists thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                    <img src="{{ url($slip->file) }}"/>
                                </div>
                            </div>
                            <br/>
                            <label class="label label-danger">{{ Lang::get('labels.pending_for_approval') }}</label>
                        </center>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop