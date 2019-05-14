<table class="table table-bordered table-hover table-striped" id="flushout_table">
    <col width="30%;">
    <col width="30%;">
    <col width="20%;">
    <col width="20%;">
    {{-- <col width="5%;"> --}}
    <?php 
        $total_amount = 0;
    ?>
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Account ID.</th>
            <th>Amount</th>
            <th>Flushout Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!$flushout_list->isEmpty())
            @foreach($flushout_list as $flushout)
                <?php
                    $total_amount += abs($flushout->amount);

                    $first_name = (!empty($flushout->first_name)) ? $flushout->first_name : '';
                    $last_name = (!empty($flushout->last_name)) ? $flushout->last_name : '';
                    $account_id = (!empty($flushout->account_id)) ? $flushout->account_id : '';
                    $amount = (!empty($flushout->amount)) ? number_format(abs($flushout->amount), 2) : 0;
                    $flushout_date = (!empty($flushout->earned_date)) ? $flushout->earned_date : '';

                ?>
                <tr>
                    <td>{{ $first_name.' '.$last_name}}</td>
                    <td>{{ $account_id}}</td>
                    <td>{{ $amount }}</td>
                    <td>{{ $flushout_date}}</td>
                    <td><a class="btn btn-info  form-control" href="{{ url('/admin/flushout-history/details/'.$flushout->f_account_id) }}">VIEW DETAILS</a></td>
                </tr>

            @endforeach
        @else
            <tr>
                <td colspan="4">
                    <center>
                        <i>No Flushout found</i>
                    </center>
                </td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr class="strong">
            <td colspan="2">Total</td>
            <td colspan="2">{{ number_format($total_amount, 2) }}</td>
        </tr>
    </tfoot>
</table>
