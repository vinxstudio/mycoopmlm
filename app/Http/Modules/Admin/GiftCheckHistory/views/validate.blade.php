@include('widgets.giftCheck.validate-modal')
<script>
    //view reason
    $(document).on('click','.btn-reason', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var reason_url = '/admin/giftcheck-history/reason/'+id;
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

    // validate function
    $(document).on('click','.btn-validate', function(e){
        e.preventDefault();
        $('#gc_id').val($(this).attr('data-id'));
        $('#label_reason').removeClass('hidden');
        $('.modal-title').text('Are you sure you want to VALIDATE this Gift Check?');
        $('#status').val('approved');
        $('#validated_by').text('');
        $('#validated_date').text('');
        $('#validate_modal').modal('show');
    });

    $(document).on('click','.btn-invalidate', function(e){
        e.preventDefault();
        $('#gc_id').val($(this).attr('data-id'));
        $('#label_reason').removeClass('hidden');
        $('.modal-title').text('Are you sure you want to INVALIDATE this Gift Check?');
        $('#status').val('disapproved');
        $('#validated_by').text('');
        $('#validated_date').text('');
        $('#validate_modal').modal('show');
    });
    
    var table_list = $('#codelist');
    $(document).on('click','#validate_submit',function(e){
        e.preventDefault();
        var form = $('#validate_form');
        var id = $('#gc_id').val();
        var validate_url = '/admin/giftcheck-history/validate-gc';
        $.ajax({
        type : 'POST',
        url  : validate_url,
        data : form.serialize(),
        success : function(data) {
                if(data.errors)
                {
                    $('#error_message').text(data.errors);
                    $('#error_message').removeClass('hidden');
                }
                else {
                    console.log(data);
                    $('#validate_modal').modal('hide');  
                    $( "#voucher_table" ).load( window.location.href+" #voucher_table" );
                }
            }
        });
    });

    $(document).on('hidden.bs.modal','#validate_modal', function() {
        $('#validate_form')[0].reset();
        $('#error_message').addClass('hidden');
        $('.modal-footer').removeClass('hidden');
    });
</script>