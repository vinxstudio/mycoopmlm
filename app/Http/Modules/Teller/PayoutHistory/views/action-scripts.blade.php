@include('Admin.PayoutHistory.views.validate_income')
<script>
    //view reason
    $(document).on('click','.btn-reason', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var reason_url = '/admin/payout-history/reason/'+id;
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
                    $('.modal-footer').addClass('hidden');
                    $('#delete_modal').modal('show');
                }
            }
        });
    });


    // $(document).on('click','.btn-approve', function(e){
    //     e.preventDefault();
    //     $(this).prop('disabled', true);
    //     var id = $(this).attr('data-id');
    //     var amount = $(this).attr('data-amount');
    //     var from = $(this).attr('data-from');
    //     var to = $(this).attr('data-to');
    //     var status = $(this).attr('data-status');
    //     var approve_url = '/admin/payout-history/approve/'+id+'/'+amount+'/'+from+'/'+to+'/'+status;
    //     $.ajax({
    //     type : 'GET',
    //     url  : approve_url,
    //     success : function(data) {
    //             if(data.errors)
    //             {
    //                 $('.modal-title').text('Error!');
    //                 $('.message').text(data.errors);
    //                 $('#confirm').addClass('hidden');
    //             }
    //             else {
    //                 $('.modal-title').text('Success!');
    //                 $('.message').text(data.message);
    //                 $('#message_modal').modal('show');
    //                 $('#confirm').addClass('hidden');
    //                 location.reload();
    //             }
    //         }
    //     });
    // });


    $(document).on('click','.btn-decline', function(e){
        e.preventDefault();
        $(this).prop('disabled', true);
        var id = $(this).attr('data-id');
        var amount = $(this).attr('data-amount');
        var from = $(this).attr('data-from');
        var to = $(this).attr('data-to');
        var status = $(this).attr('data-status');
        var approve_url = '/admin/payout-history/decline/'+id+'/'+amount+'/'+from+'/'+to+'/'+status;
        $.ajax({
        type : 'GET',
        url  : approve_url,
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
                    $('#message_modal').modal('show');
                    $('#confirm').addClass('hidden');
                    // location.reload();
                }
            }
        });
    });

    // delete function
    $(document).on('click','.btn-cancel', function(e){
        e.preventDefault();
        $('#activation_id').val($(this).attr('data-id'));
        $('#delete_modal').modal('show');
    });
    
    // $(document).on('click','#delete_submit', function(e){
    //     e.preventDefault();
    //     var id = $('#activation_id').val();
    //     var reason_url = '/admin/payout-history/approve/'+id;
    //     $.ajax({
    //     type : 'POST',
    //     url  : reason_url,
    //     data : $('#delete_form').serialize(),
    //     success : function(data) {
    //             if(data.errors){
    //                 alert(data.errors);
    //             }else {
    //                 alert(data.message);
    //                 $('#delete_modal').modal('hide');  
    //                 location.reload();
    //             }
    //         }
    //     });
    // });

</script>