<?php
    ini_set('max_execution_time', 30000);
?>
<html>
    <body>
        <table border="1">
            <tr>
                <th>Upline</th>
                <th>Left User</th>
                <th>Right User</th>
                <th>Voucher Value</th>
                <th>Converted Value</th>
                <th>Converted to</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Validated By</th>
                <th>Pairing Date</th>
                <th>Date Converted</th>
                <th>Date Validated</th>
            </tr>
            @foreach($convert_gc as $gc)
                
                <?php
                    $uplineFullname = (!empty($gc->upline_fullName))? $gc->upline_fullName : '';
                    $uplineAccount_id = (!empty($gc->upline_details->account_id))? strtoupper($gc->upline_details->account_id) : '';
                    $uplineType = (!empty($gc->membership_upline->membership_type_name))? $gc->membership_upline->membership_type_name : '';

                    $rightFullname = (!empty($gc->right_fullName))? $gc->right_fullName : '';
                    $rightAccount_id = (!empty($gc->right_details->account_id))? strtoupper($gc->right_details->account_id) : '';
                    $rightType = (!empty($gc->membership_right->membership_type_name))? $gc->membership_right->membership_type_name : '';

                    $leftFullname = (!empty($gc->left_fullName))? $gc->left_fullName : '';
                    $leftAccount_id = (!empty($gc->left_details->account_id))? strtoupper($gc->left_details->account_id) : '';
                    $leftType = (!empty($gc->membership_left->membership_type_name))? $gc->membership_left->membership_type_name : '';
                    
                    $first_name = (!empty($gc->first_name))? $gc->first_name : '';
                    $last_name = (!empty($gc->last_name))? $gc->last_name : '';

                    $validated_by = $first_name.' '.$last_name;
                    $validated_date = ($gc->status != 'pending') ? $gc->updated_at : '';
                    $status = (!empty($gc->status)) ? $gc->status : '';
                    $reason = (!empty($gc->reason)) ? $gc->reason : '';

                    $voucher_value = (!empty($gc->voucher_value))? number_format($gc->voucher_value, 2) : '';
                    $converted_voucher_value = (!empty($gc->converted_voucher_value))? number_format($gc->converted_voucher_value, 2) : '';
                    $gc_type = (!empty($gc->type))? $gc->type : '';
                    $earned_date = (!empty($gc->earned_date))? $gc->earned_date : '';
                    $created_at = (!empty($gc->created_at))? $gc->created_at : '';
                
                ?>
                <tr>
                    <td>
                        {{$uplineFullname.'('.$uplineAccount_id.'-'.$uplineType.')'}}
                    </td>
                    <td>
                        {{$leftFullname.'('.$leftAccount_id.'-'.$leftType.')'}}
                    </td>
                    <td>
                        {{$rightFullname.'('.$rightAccount_id.'-'.$rightType.')'}}
                    </td>
                    <td>{{$voucher_value}}</td>
                    <td>{{$converted_voucher_value}}</td>
                    <td>{{$gc_type}}</td>
                    <td>{{$status}}</td>
                    <td>{{$reason}}</td>
                    <td>{{$validated_by}}</td>
                    <td>{{$earned_date}}</td>
                    <td>{{$created_at}}</td>
                    <td>{{$validated_date}}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
