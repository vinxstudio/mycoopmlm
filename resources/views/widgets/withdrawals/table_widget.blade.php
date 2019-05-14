<table class="table table-bordered table-hover table-striped">
    <thead>
        @if ($theUser->role == 'admin')
            <th>{{ Lang::get('withdrawal.requested_by') }}</th>
        @endif
        <th>{{ Lang::get('withdrawal.amount') }}</th>
        <th>{{ Lang::get('withdrawal.bank_details') }}</th>
        <th>{{ Lang::get('withdrawal.notes') }}</th>
        <th>{{ Lang::get('withdrawal.requested_date') }}</th>
        <th>{{ Lang::get('withdrawal.status') }}</th>

        <!-- Source -->
        <!-- Where the withdrawal request is from -->
        <th>
            Source
        </th>

        <!-- check if it's member history -->
        <!-- if exist add reason table data head -->
        <!-- Reason -->
        @if(! empty($member_history))
            @if($member_history == true)
                <th>
                    Reason
                </th>
            @endif
        @endif
        <th>{{ Lang::get('withdrawal.action') }}</th>
    </thead>
    <tbody>
    @if ($withdrawals->count() > 0)
        @foreach($withdrawals as $row)
            <?php $total_amount = ($row->amount + $row->savings + $row->shared_capital + $row->maintenance)?>
            <?php
                $tax = $company->withdrawalSettings->tax_percentage;
                $adminFee = $company->withdrawalSettings->admin_charge;
                $totalTax = calculatePercentage($tax, $total_amount);

                if($row->source == 'redundat_binary_income'){
                    $deduct_amount = $company->redundant_binary_deduction_amount();
                    $totalTax = (int)$deduct_amount;
                }
                

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
                <td>
                    <table>
                        <tr>
                            <td>{{ Lang::get('withdrawal.requested_amount') }}</td>
                            <td>: <b>{{ number_format($row->amount, 2) }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('withdrawal.savings') }}</td>
                            <td>: <b style="color:red">{{ number_format($row->savings, 2) }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('withdrawal.cbu') }}</td>
                            <td>: <b style="color:red">{{ number_format($row->shared_capital, 2) }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('labels.maintenance') }}</td>
                            <td>: <b style="color:red">{{ number_format($row->maintenance, 2) }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('withdrawal.tax') }}</td>
                            <td>: <b style="color:red">-{{ number_format($totalTax, 2) }}</b></td>
                        </tr>
                        {{-- <!-- <tr>
                            <td>{{ Lang::get('withdrawal.admin_fee') }}</td>
                            <td>: <b style="color:red">-{{ number_format($adminFee, 2) }}</b></td>
                        </tr> --> --}}
                        <tr>
                            <td style="border-top:1px solid gray;">{{ Lang::get('withdrawal.net') }}</td>
                            <td style="border-top:1px solid gray;"><b style="color:green; font-size:18px">{{ number_format($total_amount - ($totalTax), 2) }}</b></td>
                        </tr>
                    </table>
                </td>
                <td>
                    @if(empty($row->amount))
                         <b>{{ $row->bank_name }}</b>
                    @else
                    <table>
                        <tr>
                            <td>{{ Lang::get('labels.bank_name') }}</td>
                            <td>: <b>{{ $row->bank_name }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('labels.bank_account_name') }}</td>
                            <td>: <b>{{ $row->account_name }}</b></td>
                        </tr>
                        <tr>
                            <td>{{ Lang::get('labels.bank_account_number') }}</td>
                            <td>: <b>{{ $row->account_number }}</b></td>
                        </tr>
                    </table>
                    @endif
                </td>
                <td class="col-md-3">{{ nl2br($row->notes) }}</td>

                <td>{{ $row->created_at }}</td>

                <!-- status -->
                <td class="col-sm-1">
                    {{ sprintf('<span class="label %s">%s</span>', $badge, strtoupper($row->status)) }}
                </td>
                <!-- source table data -->
                <td>
                    <div class="font-bold">
                        @if($row->source == 'earnings_income')
                            Shared Income
                        @elseif($row->source == 'redundat_binary_income')
                            Redundant Binary Income
                        @endif
                    </div>
                </td>
                <!-- reason table data -->
                <!-- if variable member history exist -->
                <!-- if exist display this table data -->
                <!-- if no don't -->
                @if( !empty($member_history))
                    @if($member_history == true)
                        <td class="col-md-2">
                            {{ $row->reason }}
                        </td>
                    @endif
                @endif
                <td class="col-sm-1"> 
                    @if ($row->status == 'pending')
                        <a href="{{ url(Request::segment(1).'/withdrawals/cancel-request/'.$row->id) }}" class="btn btn-warning btn-xs cancel_request">{{ Lang::get('withdrawal.cancel_request') }}</a>
                        
                        @if ($theUser->role == 'admin')
                           <a href="{{ url(Request::segment(1).'/withdrawals/approve-request/'.$row->id) }}" class="btn btn-success btn-xs approve_request mt-5">{{ Lang::get('withdrawal.approve_request') }}</a>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="10"><center>{{ Lang::get('withdrawal.no_request') }}</center></td>
        </tr>
    @endif
    </tbody>
</table>

<!-- Modal -->
<div id="withdrawal_reason" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="reason-modal-alert" class="hide alert alert-dismissible show" role="alert">
                    </div>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Reason</h4>
                </div>
                <div class="modal-body">
                    <h4 class="message"></h4>
                    <textarea maxlength="800" rows="54" cols="10" id="withdrawal_reason_message" name="withdrawal_reason_message" class="form-control" style="resize: none; height: 170px;" required></textarea>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                        Close
                </button>
                <button type="button" class="btn btn-success" id="modal-btn-confirm">
                        Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!--
    <script src="{{url('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
-->
<script>

    //CKEDITOR.replace('withdrawal_reason_message');

    var href = '';

    var who_button = '';

    var alert = $('#reason-modal-alert');

    $(document).ready(function(){

        // cancel request a tag
        $('.cancel_request').click(function(e){
            e.preventDefault();
            
            var modal = $('#withdrawal_reason');

            href = $(this).attr('href');

            who_button = 'cancel';

            modal.appendTo('body').modal('show');

        });
        // approve request tag
        $('.approve_request').click(function(e){
            e.preventDefault();

            var modal = $('#withdrawal_reason');

            href = $(this).attr('href');

            who_button = 'approve';

            modal.appendTo('body').modal('show');

        });
        // if modal confirm is click
        $('#modal-btn-confirm').click(function(e){
            
            let reason = $('#withdrawal_reason_message').val();
            
            let lhref = href + '/' + reason;

            // who button = 
            // approve ?
            // cancel 
            // if approve
            if(who_button == 'approve' )
            {
                alert.removeClass('hide');
                alert.removeClass('alert-danger');

                alert.text('Success');

                alert.addClass('alert-success');

                 window.location.href = lhref;
            
            }
            // if cancel
            else if(who_button == 'cancel')
            {
                // check if textarea have a reason
                if(reason == '')
                {
                    alert.removeClass('hide');
                    alert.removeClass('alert-success');

                    alert.text('Please add reason');

                    alert.addClass('alert-danger');
                }
                // if not
                else
                {
                    alert.removeClass('hide');
                    alert.removeClass('alert-danger');
                    alert.removeClass('alert-success');

                    alert.text('Success');

                    alert.addClass('alert-success');

                    window.location.href = lhref;
                }

            }

        });
        // when modal is close
        $('#withdrawal_reason').on('hidden.bs.modal', function(e){
           
            $('#withdrawal_reason_message').val('');
            
            href = '';

            alert.addClass('hide');

            alert.removeClass('alert-success');
            alert.removeClass('alert-danger');
            alert.empty();
        });

    });

</script>

<style>

    .font-bold{
        font-weight: bold;
    }

</style>