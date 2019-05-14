@include('widgets.activationCodes.delete-modal')
<script>
    //view reason
    $(document).on('click','.btn-reason', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var reason_url = '/admin/activation-codes/reason/'+id;
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

    // delete function
    $(document).on('click','.btn-delete', function(e){
        e.preventDefault();
        $('#activation_id').val($(this).attr('data-id'));
        $('#delete_modal').modal('show');
    });
    
    var table_list = $('#codelist');
    $(document).on('click','#delete_submit',function(e){
        e.preventDefault();
        var form = $('#delete_form');
        var id = $('#activation_id').val();
        var delete_url = '/admin/activation-codes/delete-code/'+id;
        $.ajax({
        type : 'POST',
        url  : delete_url,
        data : form.serialize(),
        success : function(data) {
                if(data.errors)
                {
                $('#error_message').text(data.errors);
                $('#error_message').removeClass('hidden');
                }
                else {
                    $('#delete_modal').modal('hide');
                    location.reload();
                    // $( "#codelist" ).load( window.location.href+" #codelist" );
                }
            }
        });
    });

    $(document).on('hidden.bs.modal','#delete_modal', function() {
        $('#delete_form')[0].reset();
        $('#error_message').addClass('hidden');
        $('.modal-footer').removeClass('hidden');
    });
</script>