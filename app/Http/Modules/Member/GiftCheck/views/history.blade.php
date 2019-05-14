@extends('layouts.members')
@section('content')
<a href="{{ url('member/dashboard') }}" class="btn btn-link"><i class="fa fa-arrow-left"></i> BACK</a>
<br>
<div class="panel panel-theme rounded shadow">
  <div class="panel-heading">
    <h3 class="panel-title">Gift Check History</h3>
  </div>
  <div class="panel-body">
    {{ view('widgets.giftCheck.giftcheck-list')->with([
        'convert_gc'=>$convert_gc
    ])->render() }}
    {{ $convert_gc->render() }}     
  </div>
</div>
{{-- @include('Member.GiftCheck.views.message_modal') --}}
@include('widgets.giftCheck.validate-modal')
<script>
  $(document).on('click','.btn-reason', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var reason_url = '/member/giftcheck/reason/'+id;
        var validate = '';
        $.ajax({
        type : 'GET',
        url  : reason_url,
        success : function(data) {
                if(data.errors)
                {
                $('#error_message').text(data.errors);
                }
                else {
                    $('#reason').val(data.reason);
                    $('.modal-title').text('Reason');
                    (data.status == 'approved') ? validate = 'Approved by: ' : validate = 'Disapproved by: ';
                    $('#validated_by').text(validate+data.fullName);
                    $('#validated_date').text('Date Validated: '+data.updated_at);
                    $('#label_reason').addClass('hidden');
                    $('.modal-footer').addClass('hidden');
                    $('#validate_modal').modal('show');
                }
            }
        });
    });
</script>
@stop
