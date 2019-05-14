@extends('layouts.emailLayout')
@section('content')
    {{ $mailContent }}

    @if (isset($verificationCode) and $verificationCode != null)
        <p style="margin:0 auto; background-color:#dedede; width:auto; text-align:center; font-family:Helvetica Neue, Helvetica, Arial; font-size:50px; color:#5d5d5d;">{{ $verificationCode }}</p>
    @endif

    @if (isset($withdrawal->id))
        <?php
            $company = getCompanyObject();
            $tax = $company->withdrawalSettings->tax_percentage;
            $adminFee = $company->withdrawalSettings->admin_fee;
            $totalTax = calculatePercentage($tax, $withdrawal->amount);
            $tdStyle = 'border-bottom:1px solid #cccccc; padding:10px 0; text-align:center; font-family:Helvetica Neue, Helvetica, Arial;';
        ?>
        <table class="withdrawal" cellspacing="0" cellpadding="0" style="margin:0 auto; width:300px;">
            <tr>
                <td style="{{ $tdStyle }}">{{ Lang::get('withdrawal.amount') }} : </td>
                <td style="{{ $tdStyle }}">{{ number_format($withdrawal->amount, 2) }}</td>
            </tr>
            <tr>
                <td style="{{ $tdStyle }}">{{ Lang::get('withdrawal.tax') }}</td>
                <td style="{{ $tdStyle }}">{{ number_format($totalTax, 2) }}</td>
            </tr>
            <tr>
                <td style="{{ $tdStyle }}">{{ Lang::get('withdrawal.admin_fee') }}</td>
                <td style="{{ $tdStyle }}">{{ number_format($adminFee, 2) }}</td>
            </tr>
            <tr>
                <td style="{{ $tdStyle }}">{{ Lang::get('withdrawal.net') }}</td>
                <td style="{{ $tdStyle }}">{{ number_format($withdrawal->amount - ($totalTax + $adminFee), 2) }}</td>
            </tr>
        </table>
    @endif
@stop