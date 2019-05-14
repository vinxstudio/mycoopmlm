<?php
    ini_set('max_execution_time', 50000);
?>
<html>
    <body>
        <table border="1">
            <?php 
                $total_amount = 0;
            ?>
           <tr>
                <th>Full Name</th>
                <th>Account ID.</th>
                <th>Amount</th>
                <th>Flushout Date</th>
            </tr>
            @if(!$flushout_list->isEmpty())
                @foreach($flushout_list as $flushout)
                    <?php
                        $total_amount += abs($flushout->amount);

                        $first_name = (!empty($flushout->first_name)) ? $flushout->first_name : '';
                        $last_name = (!empty($flushout->last_name)) ? $flushout->last_name : '';
                        $account_id = (!empty($flushout->account_id)) ? $flushout->account_id : '';
                        $amount = (!empty($flushout->amount)) ? number_format(abs($flushout->amount), 2) : '';
                        $flushout_date = (!empty($flushout->created_at)) ? $flushout->created_at : '';

                    ?>
                    <tr>
                        <td>{{ $first_name.' '.$last_name}}</td>
                        <td>{{ $account_id}}</td>
                        <td>{{ $amount }}</td>
                        <td>{{ $flushout_date}}</td>
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
            <tfoot>
                <tr class="strong">
                    <td colspan="2">Total</td>
                    <td colspan="2">{{ number_format($total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
