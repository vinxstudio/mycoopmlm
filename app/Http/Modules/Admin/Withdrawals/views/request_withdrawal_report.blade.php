<?php
$withdrawals = $requestedlist['withdrawals'];
$date_from = $requestedlist['date_from'];
$date_to = $requestedlist['date_to'];

$start_date = date("M d, Y", strtotime($date_from));
$end_date = date("M d, Y", strtotime($date_to));

$total_earnings = 0;
?>

<table class="table table-bordered table-hover table-striped">
    <tr>
        <th colspan="12" style="text-align: center;">Request Withdrawal ({{$start_date}} - {{$end_date}} )</th>
    </tr>
    <tr>
        @if ($theUser->role == 'admin')
            <th>{{ Lang::get('withdrawal.requested_by') }}</th>
        @endif
        <th>Requested Amount</th>
        <th>Savings</th>
        <th>CBU</th>
        <th>Admin Fee</th>
        <th>Net</th>
        <th>Bank Name</th>
        <th>Account Name</th>
        <th>Account Number  </th>
        <th>{{ Lang::get('withdrawal.notes') }}</th>
        <th>{{ Lang::get('withdrawal.requested_date') }}</th>
        <th>{{ Lang::get('withdrawal.status') }}</th>
    </tr>
    <tr></tr>
    @if ($withdrawals->count() > 0)
        @foreach($withdrawals as $row)
	    <?php $total_amount = ($row->amount + $row->savings + $row->shared_capital)?>
            <?php
                $tax = $company->withdrawalSettings->tax_percentage;
                $adminFee = $company->withdrawalSettings->admin_charge;
                $totalTax = calculatePercentage($tax, $total_amount);

                switch($row->status){
                    case 'denied':
                        $badge = 'label-danger';
                        break;

                    case 'approved':
                        $badge = 'label-success';
                        break;

                    default:
                        $badge = 'label-warning';
                }
            ?>
            <tr>
                @if ($theUser->role == 'admin')
                    <td>{{ $row->user->details->fullName }}</td>
                @endif
              
                <td> {{ number_format($row->amount, 2) }}</td>
                <td> {{ number_format($row->savings, 2) }}</td>
                <td>{{ number_format($row->shared_capital, 2) }}</td>
                <td> <b style="color:red">-{{ number_format($totalTax, 2) }}</b></td>
                <td style="border-top:1px solid gray;">: <b style="color:green; font-size:18px">{{ number_format($total_amount - ($totalTax), 2) }}</b></td>
                <td> {{ $row->bank_name }} </td>
                <td>{{ $row->account_name }}</td>
                <td>{{ $row->account_number }}</td>
                <td>{{ $row->notes }}</td>

                <td>{{ $row->created_at }}</td>

                <td>{{ sprintf('<span class="label %s">%s</span>', $badge, strtoupper($row->status)) }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="10"><center>{{ Lang::get('withdrawal.no_request') }}</center></td>
        </tr>
    @endif
</table>
