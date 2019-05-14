<script>
    $(document).on('click', '#btn-modal', function(e){
        e.preventDefault();
        var user_id = $(this).attr('data-id');
        var member_details = '/admin/members/member-details';
        $.ajax({
            type : 'GET',
            url  : member_details,
            data : {
                'user_id' : user_id
            },
            success : function(data) {

                console.log(data);

                $('.modal-title').text('Edit Details of '+ (data.first_name) + (data.last_name) );
                $('.edit_user_id').val(data.id);
                $('.edit_fname').val(data.first_name);
                $('.edit_lname').val(data.last_name);
                $('.edit_email').val(data.email);
                $('.edit_bankname').val(data.bank_name);
                $('.edit_accountname').val(data.account_name);
                $('.edit_accountnumber').val(data.account_number);
                $('.edit_username').val(data.username);
                // sponsor name
                $('.edit_sponsor').val(data.sponsor_name);
                // sponsor id hidden
                $('.edit_sponsor_id').val(data.sponsor_id);
                // user account id
                $('.edit_user_account_id').val(data.user_account_id);
                $('#editModal').modal('show');
            }
        });
        
        // $('#editModal').modal('show');
    });

    $(document).on('click', '#btn-update', function(e){
        e.preventDefault();
        var user_id = $('.edit_user_id').val();
        var password = $('#password').val();
        var confirm_password = $('#password_confirmation').val();
        var member_details = '/admin/members/member-details';
        $.ajax({
            type : 'POST',
            url  : member_details,
            data : {
                'user_id' : user_id,
                'password' : password,
                'password_confirmation' : confirm_password
            },
            success : function(data) {
                if(data.errors)
                {
                    (data.errors.password) ? $('#error_password').text(data.errors.password) : $('#error_password').text('');
                    (data.errors.password_confirmation) ? $('#error_confirm_password').text(data.errors.password_confirmation) : $('#error_confirm_password').text('');
                }
                else
                {
                    $('#error_password').text('');
                    $('#error_confirm_password').text('');
                    $('#editModal').modal('hide');
                    alert(data.success);
                }
            }
        });
        
    });

    $('body').on('hidden.bs.modal', function () {
        $('#error_password').text('');
        $('#error_confirm_password').text('');
        $('#password').val('');
        $('#password_confirmation').val('');
    });

    // small_modal are declared in index.blade.php
    // also the title and body
    // small_modal 
    // small_modal_title
    // small_modal_body

    // button for changing sponsor
    var sponsor_btn = $('.e_sponsor_btn_change');
    
	$(document).ready(function(){

        // append modal to body
        // error see stackoverflow
		$('#editModal').appendTo('body');

        sponsor_btn.click(function(e){
            e.preventDefault();

            // title of small modal
            small_modal_title.text('Change Sponsor');
            // append search layout for user
            // and div for message
            small_modal_body.append(LinkLayout()).append('<div class="small-body-message"></div>');
            
            small_modal.modal('show');

            // create variable for btn confirm and search user submit
            let confirm_btn = small_modal.find('.btn-confirm');
            let search_user = $('.search-user');

            let small_message = small_modal.find('.small-body-message');
            
            // get user account id
            // the user account_id of this when edit button is click
            let user_account_id = $(this).siblings('.edit_user_account_id').eq(0).val();
            let new_sponsor_account_id = -1;

            search_user.submit(function(e){

                e.preventDefault();

                    // search user
                    $.ajax({
                        url: '/admin/members/search-user/',
                        method: 'GET',
                        dataType: 'JSON',
                        data: $(this).serialize()
                    }).done(function(data){

                        console.log(data)

                        // empty modal message first and add new
                        small_message.empty().append(EditSponsorLayout(data.message.username, data.message.fullname));

                        $.ajax({
                            url: '/admin/members/get-account-id/',
                            method: 'GET',
                            dataType: 'JSON',
                            data: {
                                user_id: data.message.id
                            } 
                        }).done(function(data){
                            console.log(data);
                            
                            if(data.account_id){
                                new_sponsor_account_id = data.account_id;
                            }

                        });

                        ShowInfo('alert-success', data.message.message, true);

                    }).fail(function(data){

                        console.log(data);

                        ShowInfo('alert-danger', data.responseJSON.message, true);

                    });

            });

            // when confirm btn is click
            confirm_btn.click(function(e){
                // check if account id is null or account id == -1 
                if(!new_sponsor_account_id || new_sponsor_account_id == -1){
                    ShowInfo('alert-danger', 'No Sponsor Inputted.', true);
                }else{

                    $.ajax({
                        url: '/admin/members/update-sponsor-id',
                        method: 'POST',
                        dataType: 'JSON',
                        data:{
                            user_account_id: user_account_id,
                            new_sponsor_account_id: new_sponsor_account_id
                        }
                    }).done(function(data){
                        
                        console.log(data);

                        ShowInfo('alert-success', data.message.message, true);

                        $('.edit_sponsor').val(data.message.sponsor_details.fullname);

                    }).fail(function(data){
                        
                        console.log(data);
                        
                    });

                }

            });

        });
        
    });
    
    function EditSponsorLayout(username, fullname)
    {
        let message = '<div class="sponsor_details">' + 
                        '<kbd>' +
                            username +
                        '</kbd>' + 
                        '<kbd>' +
                            fullname +
                        '</kbd>' +
                    '</div>';

        return message;
    }

</script>

<style>

    .sponsor_details{
        margin-top: 10px;
        max-width: 100%;
        display: block;
        overflow: hidden;
    }

    .sponsor_details > kbd{
        margin: 2px;
        padding: 5px;
        display: block;
        font-size: 1em;
    }



</style>