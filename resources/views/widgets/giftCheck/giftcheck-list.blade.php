<table class="table table-bordered table-hover table-striped" id="voucher_table">
    <col width="15%;">
    <col width="15%;">
    <col width="15%;">
    <col width="5%;">
    <col width="5%;">
    <col width="10%;">
    <col width="10%;">
    <col width="10%;">
    <col width="10%;">
    <col width="10%;">
    {{-- <col width="5%;"> --}}
    <?php
        $total_voucher = 0;
        $total_converted = 0;
    ?>
    <thead>
        <tr>
            <th>Upline</th>
            <th>Left User</th>
            <th>Right User</th>
            <th>Voucher Value</th>
            <th>Converted Value</th>
            <th>Converted to</th>
            <th>Status</th>
            <th>Pairing Date</th>
            <th>Date Converted</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!$convert_gc->isEmpty())
            @foreach($convert_gc as $gc)
                <?php
                    $total_voucher += $gc->voucher_value;
                    $total_converted += $gc->converted_voucher_value;

                    if($gc->status == 'pending')
                    {
                        $color = 'text-warning';
                    }
                    elseif($gc->status == 'approved')
                    {
                        $color = 'text-success';
                    }
                    else
                    {
                        $color = 'text-danger';
                    }
                ?>
                <tr>
                    <td>
                        {{'Full Name: '.$gc->upline_fullName}}<br>
                        {{'Account ID.: '.strtoupper($gc->upline_details->account_id)}}<br>
                        {{'Type: '.$gc->membership_upline->membership_type_name}}
                    </td>
                    <td>
                        {{'Full Name: '.$gc->left_fullName}}<br>
                        {{'Account ID.: '.strtoupper($gc->left_details->account_id)}}<br>
                        {{'Type: '.$gc->membership_left->membership_type_name}}
                    </td>
                    <td>
                        {{'Full Name: '.$gc->right_fullName}}<br>
                        {{'Account ID.: '.strtoupper($gc->right_details->account_id)}}<br>
                        {{'Type: '.$gc->membership_right->membership_type_name}}
                    </td>
                    <td>{{number_format($gc->voucher_value, 2)}}</td>
                    <td>{{ number_format($gc->converted_voucher_value,2)}}</td>
                    <td>{{$gc->type}}</td>
                    <td class="{{$color}}">{{strtoupper($gc->status)}}</td>
                    <td>{{$gc->earned_date}}</td>
                    <td>{{$gc->created_at}}</td>
                    @if(Request::segment(1) == 'member')
                        @if($gc->status == 'approved' || $gc->status == 'disapproved')
                            <td><button class="btn btn-primary btn-sm btn-reason form-control" data-id={{ $gc->id }}>REASON</button></td>
                        @else
                            <td></td>
                        @endif
                    @endif
                    @if(Request::segment(1) != 'member')
                        @if($gc->status == 'pending')
                            <td>
                                <button class="btn btn-success btn-sm btn-validate form-control" data-id={{ $gc->id }}>VALIDATE</button>
                                
                                <button class="btn btn-danger btn-sm btn-invalidate form-control" data-id={{ $gc->id }}>INVALIDATE</button>
                            </td>
                        @elseif($gc->status == 'approved' || $gc->status =='disapproved' )
                            <td><button class="btn btn-primary btn-sm btn-reason form-control" data-id={{ $gc->id }}>REASON</button></td>
                        @endif
                    @endif
                    
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9">
                    <center>
                        <i>No Converted Giftcheck</i>
                    </center>
                </td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr class="strong">
            <td colspan="3">Total</td>
            <td>{{ number_format($total_voucher, 2) }}</td>
            <td>{{ number_format($total_converted, 2) }}</td>
            <td colspan="5"></td>
        </tr>
    </tfoot>
</table>