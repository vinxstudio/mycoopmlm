@include('Admin.PayoutHistory.views.validate_income')
<script>
    //view reason
    // $(document).on('click','.btn-reason', function(e){
    //     e.preventDefault();
    //     var id = $(this).attr('data-id');
    //     var reason_url = '/admin/payout-history/reason/'+id;
    //     $.ajax({
    //     type : 'GET',
    //     url  : reason_url,
    //     success : function(data) {
    //             if(data.errors)
    //             {
    //             $('#error_message').text(data.errors);
    //             }
    //             else {
    //                 $('#reason').val(data.reason);
    //                 $('.modal-footer').addClass('hidden');
    //                 $('#delete_modal').modal('show');
    //             }
    //         }
    //     });
    // });


    $(document).on('click','.btn-approve', function(e){
        e.preventDefault();
        let details = {};
        $(this).prop('disabled', true);
        details['group_id'] = $(this).attr('data-groupId');
        details['user_id'] = $(this).attr('data-id');
        details['gross_income'] = $(this).attr('data-grossAmount');
        details['admin_fee'] = $(this).attr('data-adminFee');
        details['cd_fee'] = $(this).attr('data-cdFee');
        details['net_income'] = $(this).attr('data-netAmount');
        details['status'] = $(this).attr('data-status');
        details['date_from'] = $(this).attr('data-from');
        details['date_to'] = $(this).attr('data-to');

        var approve_url = '/admin/payout-history/approve';
        // var id = $(this).attr('data-id');
        // var amount = $(this).attr('data-amount');
        // var from = $(this).attr('data-from');
        // var to = $(this).attr('data-to');
        // var status = $(this).attr('data-status');
        // var approve_url = '/admin/payout-history/approve/'+id+'/'+amount+'/'+from+'/'+to+'/'+status;
        $.ajax({
        type : 'POST',
        url  : approve_url,
        data : details,
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
                    location.reload();
                }
            }
        });
    });

    //  ----------------------------

    //  jquery function for decline button in income_history blade view
    //  old decline weekly payout history button function
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
                }
            }
        });
    });
    

    // 
    $(document).ready(function(){

        // Approved group id
        var data_group_id;
        // approved gross ammount
        var data_gross_amount;
        // approved admin fee
        var data_admin_fee;
        // approved cd fee
        var data_cd_fee;
        // ----------
        // the id of the user
        var data_id;
        // the ammount of the user to be approved
        var data_ammount;
        // the data date from payout
        var data_from;
        // the data date to payout
        var data_to;
        // the data status of the user
        var data_status;
        // the reason to be inputted from the admin
        var data_message;

        // the get url to for declining an weekly payout
        var approve_url;

        // the reason
        var data_reason;
        // class to be added to the alert
        var data_alert_class;
        //  the message of the alert
        var data_alert_message;

        var data_who;
        //
        const approved = 'approved';
        const declined = 'declined';

        // button to be enabled after closing modal
        var button_who; 

        // i've created a new function
        // so that i won't be touching the function above
        // new weekly payout decline button function
        // when decline button is click
        $('.btn-approve-decline').click(function(e){
            // you know e.preventDefault is useless if the button
            // is not inside form
            e.preventDefault();

            $(this).prop('disabled', true);
            
            button_who = $(this);
            // get group id of approve 
            // undefined if decline
            data_group_id = $(this).attr('data-groupId');
            // undefined if decline
            data_gross_amount= $(this).attr('data-grossAmount');
            data_admin_fee = $(this).attr('data-adminFee');
            data_cd_fee = $(this).attr('data-cdFee');

            // assign the user id
            data_id = $(this).attr('data-id');
            // assign the ammount of the user
            data_ammount= $(this).attr('data-netAmount');
            // assign data date from
            data_from = $(this).attr('data-from');
            // assign data date to
            data_to = $(this).attr('data-to');
            // assign data status 
            data_status = $(this).attr('data-status');

            // get from whos button is this 
            // approve or decline
            data_who = $(this).attr('data-who');

            // show the modal
            $('#new_message_modal').modal('show');
        });

        // when modal confirm button is click
        $('#modal-btn-confirm').click(function(e){
            // you know e.preventDefault is useless if the button
            // is not inside form
            e.preventDefault();

            // first get the reason message
            data_reason = $('#reason-message').val();

            // if data is approved
            if(data_who == approved)
            {
                // assign json values
                let details = {
                    'group_id' : data_group_id,
                    'user_id' : data_id,
                    'gross_income' : data_gross_amount,
                    'admin_fee' : data_admin_fee,
                    'cd_fee' : data_cd_fee,
                    'net_income' : data_ammount,
                    'status' : data_status,
                    'date_from' : data_from,
                    'date_to' : data_to,
                    'reason' : data_reason
                };
                
                approve_url = '/admin/payout-history/approve';
                
                $.ajax({
                    type : 'POST',
                    url  : approve_url,
                    data : details,
                    success : function(data_json) {
                        // show method for showing info
                        console.log(data_json);
                        ShowInfoSuccessCallback(data_json);
                    }   
                });
                
            }
            else if(data_who == declined)
            {
                // if reason string empty
                if(data_reason == '')
                {  
                    // assign an alert message
                    data_alert_message = 'Please input a reason to decline!';
                    // assign an alert class
                    data_alert_class = 'alert-danger';

                    // empty the text inside the div alert class
                    $('#new-message-modal-alert').empty();
                    // add the new text
                    $('#new-message-modal-alert').append(data_alert_message);

                    // also remove the hide class
                    $('#new-message-modal-alert').removeClass('hide');
                    // also add the alert-etc class
                    $('#new-message-modal-alert').addClass(data_alert_class);
                }
                else if(data_reason != '')
                {
                    // assigning of url to
                    approve_url = '/admin/payout-history/decline';

                    let details = { 
                        'id' : data_id, 
                        'ammount' : data_ammount, 
                        'from' : data_from, 
                        'to' : data_to, 
                        'status' : data_status, 
                        'reason' : data_reason
                     };

                    // ajax get call
                    $.ajax({
                        // method
                        method : 'POST',
                        // type is get
                        // type : 'GET',
                        // url the assign url
                        // '+data_id+'/'+data_ammount+'/'+data_from+'/'+data_to+'/'+data_status+'/'+data_reason;
                        url  : approve_url,
                        data : details,
                        success : function(data_json){
                            // call method to show info
                            console.log(data_json)
                            ShowInfoSuccessCallback(data_json);
                        }
                    });
                }
            }
        });

        // when modal is close
        $('#new_message_modal').on('hidden.bs.modal', function(e){
            // empty the text inside div of alert
            $('#new-message-modal-alert').empty();
            // empty reason message
            $('#reason-message').val('');
            // add the hide class to hide the alert
            $('#new-message-modal-alert').addClass('hide');
            // also remove the alert-etc to be usable for another alert class
            $('#new-message-modal-alert').removeClass(data_alert_class);
            // remove the disabled attribute
            button_who.prop('disabled', false);

            // unsigned variable values
            data_group_id = '';
            data_gross_amount = '';
            data_admin_fee = '';
            data_cd_fee = '';
            data_id = '';
            data_ammount = '';
            data_from = '';
            data_to = '';
            data_status = '';
            data_message = '';
            approve_url = '';
            data_reason = '';
            data_alert_class = '';
            data_alert_message = '';
            data_who = '';

        });
        

    });

    // delete function
    // $(document).on('click','.btn-cancel', function(e){
    //     e.preventDefault();
    //     $('#activation_id').val($(this).attr('data-id'));
    //     $('#delete_modal').modal('show');
    // });
    
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


    // Showing info for AJAX success callback 
    // @param data response = data_json
    function ShowInfoSuccessCallback(data)
    {
        if(data.errors)
        {
            // assign an alert class
            data_alert_class = 'alert-danger';
            // assign the message
            data_alert_message = data.errors;
            // empty the text inside the div alert class
            $('#new-message-modal-alert').empty();
            // add the new text
            $('#new-message-modal-alert').append(data_alert_message);
            // also remove the hide class
            $('#new-message-modal-alert').removeClass('hide');
            // also add the alert-etc class
            $('#new-message-modal-alert').addClass(data_alert_class);
        }
        else {
            // remove danger class if exist
            $('#new-message-modal-alert').removeClass('alert-danger');
            // assign an alert class
            data_alert_class = 'alert-success';
            // assign the message
            data_alert_message = data.message;
            // empty the text inside the div alert class
            $('#new-message-modal-alert').empty();
            // also add the alert-etc class
            $('#new-message-modal-alert').addClass(data_alert_class);
            // add the new text
            $('#new-message-modal-alert').append(data_alert_message);
            // also remove the hide class
            $('#new-message-modal-alert').removeClass('hide');
            location.reload();
        }
    }

</script>