@extends('layouts.master')
@section('content')

    <table class="dataTable table table-bordered table-hover table-striped">
        <thead>
            <th>{{ Lang::get('members.name') }}</th>
            <th>{{ Lang::get('payment.amount') }}</th>
            <th>{{ Lang::get('payment.paid_via') }}</th>
            <th>{{ Lang::get('labels.status') }}</th>
            <th>{{ Lang::get('payment.attachment') }}</th>
            <th>{{ Lang::get('labels.action') }}</th>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->user->details->fullName }}</td>
                    <td>{{ config('money.currency_symbol') }}{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->paidVia }}</td>
                    <td>
                        <label class="label {{ ($payment->status == PENDING_STATUS) ? 'label-warning' : ($payment->status == DENIED_STATUS) ? 'label-danger' : 'label-success' }}">{{ ucwords($payment->status) }}</label>
                    </td>
                    <td>
                        @if (file_exists($payment->file))
                            <img src="{{ url($payment->file) }}" onclick="modal('Proof of Payment', '#preview-<?php echo $payment->id ?>')" width="50" height="50" alt=""/>
                            <div id="preview-{{ $payment->id }}" class="hidden">
                                <img style="float:left; width:100%;" src="{{ url($payment->file) }}" alt=""/>
                            </div>
                        @endif
                    </td>
                    <td>
                        @if ($payment->status == PENDING_STATUS)
                            <a href="{{ url('admin/payment-history/action/approve/'.$payment->id) }}" class="btn btn-success btn-xs">{{ Lang::get('labels.approve') }}</a>
                            <a href="{{ url('admin/payment-history/action/deny/'.$payment->id) }}" class="btn btn-danger btn-xs">{{ Lang::get('labels.deny') }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop