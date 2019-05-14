<?php
    ini_set('max_execution_time', 5000);
    ini_set('memory_limit','256M');
?>
<html>
    <body>
        <table border="1">
            <tr>
                <th>Activation Code</th>
                <th>Account ID.</th>
                <th>OR#</th>
                <th>Teller / Branch</th>
                <th>Teller Username</th>
                <th>Paid Amount</th>
                <th>Status</th>
                <th>Type</th>
                <th>Created At</th>
                <th>Transferred to</th>
            </tr>
            @foreach($codes as $code)
            <?php

                $activation_code = (!empty($code->code))? $code->code : '';
                $account_id = (!empty($code->account_id))? $code->account_id : '';
                $or_num = (!empty($code->or_number))? $code->or_number : '';
                $teller_branch = (!empty($code->teller_id)) ? $code->first_name.' '.$code->last_name : '';
                $paid_amount = (!empty($code->membership->entry_fee))? number_format($code->membership->entry_fee,2) : '';
                $status = (!empty($code->status))? ucwords($code->status) : '';
                $type = (!empty($code->type))? ucwords($code->type) : '';
                $created_at = (!empty($code->created_at))? ucwords($code->created_at) : '';
                $transferred_to = (!empty($code->transferred_to))? ucwords($code->transferred_to) : '';

                $address = explode(" - ", $code->name);
              
            ?>
            <tr>
                <td>{{ $activation_code }}</td>
                <td>{{ $account_id }}</td>
                <td>{{ $or_num }}</td>
                <td>
                    {{ $teller_branch }}
                    @if (!empty($code->name))
                        ({{$address[1]}})
                    @endif
                </td>
                <td>{{ $code->username }}</td>
                <td>{{ $paid_amount }}</td>
                <td>{{ $status }}</td>
                <td>{{ $type }}</td>
                <td>{{ $created_at }}</td>
                <td>{{ $transferred_to }}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>
