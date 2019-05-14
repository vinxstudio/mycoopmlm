@extends('layouts.members')
@section('content')
<a href="{{ url('member/dashboard') }}" class="btn btn-link"><i class="fa fa-arrow-left"></i> BACK</a>

<br>
<div class="panel panel-theme rounded shadow">
  <div class="panel-heading">
    <h3 class="panel-title">Gift Check List</h3>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="voucher_table">
            <col width="15%;">
            <col width="15%;">
            <col width="15%;">
            <col width="15%;">
            <col width="20%;">
            <col width="20%;">
            {{-- <col width="5%;"> --}}
            <thead>
                <tr>
                    <th>Upline</th>
                    <th>Left</th>
                    <th>Right</th>
                    <th>Pairing Date</th>
                    <th>Voucher</th>
                    <th>Convert to</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @if ($giftCheck->isEmpty())
                    <tr>
                        <td colspan="6">
                            <center>
                                <i>No Records Found</i>
                            </center>
                        </td>
                    </tr>
                @else
    
                    @foreach ($giftCheck as $gc)
                        <tr>
                            <td>
                                Name : {{ $gc->uName }}<br>
                                ({{ !empty($gc->upline_account_id->account_id) ? strtoupper($gc->upline_account_id->account_id): 'No Account ID.';}})<br>
                                Type : {{ !empty($gc->membership_upline->membership_type_name) ? $gc->membership_upline->membership_type_name : 'Empty' }}
                                <br>
                            </td>
                            <td>
                                Name : {{ !empty($gc->lName) ? $gc->lName : 'Empty' }}<br>
                                ({{ !empty($gc->left_account_id->account_id) ? strtoupper($gc->left_account_id->account_id): 'No Account ID.'; }})<br>
                                Type: {{ !empty($gc->membership_left->membership_type_name) ? $gc->membership_left->membership_type_name : 'Empty' }}
                                <br>
                            </td>
                            <td>
                                Name : {{ $gc->rName }}<br>
                                ({{ !empty($gc->right_account_id->account_id) ? strtoupper($gc->right_account_id->account_id): 'No Account ID.';}})<br>
                                Type : {{ !empty($gc->membership_right->membership_type_name) ? $gc->membership_right->membership_type_name : 'Empty' }}
                                <br>
                            </td>
                            <td>{{$gc->earned_date}}</td>
                            <td class="text-center"><img src="{{ $gc->img_voucher }}" style="width: 300px;"></td>
                            @if(!$gc->converted)
                            <td>
                                <select class="form-control convert_type" name="convert_type">
                                    <option value="">--Select--</option>
                                    <option value="{{'CBU(Shared Capital)-'.$gc->voucher_value.'-'.$gc->id.'-'.$gc->user_id.'-'.$gc->account_id.'-'.$gc->voucher_amount}}">
                                        CBU(Shared Capital)
                                    </option>
                                    {{-- <option value="{{'Savings-'.$gc->voucher_value.'-'.$gc->id.'-'.$gc->user_id.'-'.$gc->account_id.'-'.$gc->voucher_amount}}">SAVINGS</option> --}}
                                    <option value="{{'Product Purchase-'.$gc->voucher_amount.'-'.$gc->id.'-'.$gc->user_id.'-'.$gc->account_id.'-'.$gc->voucher_amount}}">PRODUCT PURCHASE</option>
                                </select>
                            </td>
                            @else
                                <td class="text-center">
                                    <span class="text-danger">
                                        Converted 
                                        <span class="d-block">
                                            -- {{ $gc->converted->type }} --
                                        </span>
                                    </span></td>
                            @endif
                            {{-- <td>
                                <button class="btn btn-primary btn-convert">Convert</button>
                            </td> --}}
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="pull-right">
        {{ $giftCheck->render() }}
    </div>
  </div>
</div>
@include('Member.GiftCheck.views.message_modal')
<script>
    var voucher = ''; 
    $(document).on('change', '.convert_type', function(e){
        $('.modal-title').text('Confirmation!');
        $('.message').text('Are you sure you want to convert this voucher?');
        $('#confirm').removeClass('hidden');
        $('#message_modal').modal('show');
        voucher = $(this).val();
        $("body").on('click', '#confirm', convertGC);
    });

    function convertGC()
    {   
        $("body").off('click', '#confirm', convertGC);
        var voucher_url = '/member/giftcheck';
        $.ajax({
            type : 'POST',
            url  : voucher_url,
            data : {
                'convert_type' : voucher
            },
            success : function(data) {
                  if(data.errors)
                  {
                    $('.modal-title').text('Error!');
                    $('.message').text(data.errors);
                    $('#confirm').addClass('hidden');
                  }
                  else {
                    $('.modal-title').text('Success!');
                    $('.message').text(data.message);
                    $('#confirm').addClass('hidden');
                    $( "#voucher_table" ).load( window.location.href+" #voucher_table" );
                }
            }
        });
    }
    
    // $(document).on('click', '#confirm', function(e){
    //     e.preventDefault();
    //     var voucher_url = '/member/giftcheck';
    //     $.ajax({
    //         type : 'POST',
    //         url  : voucher_url,
    //         data : {
    //             'convert_type' : voucher
    //         },
    //         success : function(data) {
    //               if(data.errors)
    //               {
    //                 $('.modal-title').text('Error!');
    //                 $('.message').text(data.errors);
    //                 $('#confirm').addClass('hidden');
    //               }
    //               else {
    //                 $('.modal-title').text('Success!');
    //                 $('.message').text(data.message);
    //                 $('#confirm').addClass('hidden');
    //                 $( "#voucher_table" ).load( window.location.href+" #voucher_table" );
    //             }
    //         }
    //     });
    // });

    $('#message_modal').on('hidden.bs.modal', function() {
        $('.convert_type').val('');
        voucher = '';
     });
</script>  

<style>
    .d-block{
        display: block;
        width: auto;
    }
</style>

@stop
