@extends('layouts.master')
@section('content')

<div>
        <label><h1>Link Accounts</h1></label>
        <div>
        {{Form::open()}}
        <div class="form-group col-md-4">
                {{Form::text('main_account', '', ['class'=>'form-control','placeholder'=>'Enter Username', 'id' => 'searchbox', 'name' => 'search'])}}
        </div>
        {{Form::close()}} 
        <a class="btn btn-info btn-search" id="search"><i class="fas fa-search"></i> Search</a>
        <a class="btn btn-danger btn-link" id="link"><i class="fa fa-link"></i> Link</a>
        {{-- <a class="btn btn-warning btn-unlink" id="unlink" disabled><i class="fa fa-unlink"></i> Unlink</a> --}}
        

        <table class="1dataTable table table-bordered table-hover table-striped table-responsive">

                <thead>
                        <th>Accounts</th>
                        <th>Group ID</th>
                        <th>Full Name</th>
                </thead>
                <tbody>

                </tbody>

        </table>
        

           
</div>

@include('Admin.LinkAccounts.views.modal')

<script>

$(document).ready(function(){

        $(document).on('click','#search', function(){
                var query = $('#searchbox').val();
                fetch_username(query);
        });


        function fetch_username(query = '')
        {
                $.ajax({
                        url:'/admin/link-accounts/search',
                        method: 'GET',
                        data: {query:query},
                        dataType: 'json',
                        success:function(data)
                        {      
                                if(data.data){
                                        console.log(data);
                                        var sub_members = '';
                                        $.each(data, function(){ 
                                                $.each(this, function(index, value){
                                                                sub_members += "<tr><td>"+value.username+"</td><td>"+value.group_id+"</td><td>"+value.first_name+" "+value.last_name+"</td></tr>";
                                                });
                                                $('tbody').html(sub_members);
                                        }); 
                                }else{
                                        sub_members += "<tr><td colspan = 3>"+ data.error +"</td></tr>";
                                        $('tbody').html(sub_members);

                                }
                                 
                        }
                })

        }

        $(document).on('click', '#link', function(e){
                e.preventDefault();
                var keyword = $('#searchbox').val();
                $.ajax({
                        type : 'GET',
                        url  : '/admin/link-accounts/link',
                        dataType: 'json',
                        data : {keyword : keyword},
                        success: function(data){          
                                if(data.sub_accounts.length < 7){
                                        console.log(data.sub_accounts);
                                        $('.group_id').val(data.data.group_id);
                                        $('.link_to').val(data.data.username);
                                        $('#link_modal').modal('show');
                                }else{
                                        $('#link_modal').modal('hide');
                                        $('#error_link_modal').modal('show');
                                }  
                        }
                });
        });

        $(document).on('click', '#link_btn_modal', function(e){
                e.preventDefault();
                var group_id = $('.group_id').val();
                var link_username = $('.link_username').val();
                console.log(link_username);
                $.ajax({
                        type : 'POST',
                        url  : '/admin/link-accounts/add-user',
                        dataType : 'json',
                        data :{
                                'group_id' : group_id,
                                'link_username' : link_username
                        },
                        success: function(data)
                        {
                                if(data.errors) 
                                {
                                        console.log(data.errors);
                                        $('#error2_link_modal').modal('show');
                                        (data.errors.link_username) ? $('#error_username').text(data.errors.link_username) : $('#error_username').text('');        
                                }
                                else
                                {
                                        console.log(data);
                                        $('.link_username').text('');
                                        $('#link_modal').modal('hide');
                                        $('#succes_link_modal').modal('show');
                                        
                                }
                        }

                });

        });

        $(document).on('click', '#unlink', function(e){
                e.preventDefault();
                var unlink_username = $('#searchbox').val();
                console.log(unlink_username);
                $.ajax({
                        type : 'POST',
                        url  : '/admin/link-accounts/unlink',
                        dataType: 'json',
                        data :{
                                'unlink_username' : unlink_username
                        },
                        success: function(data)
                        {
                                if(data.errors) 
                                {
                                        console.log(data.errors);
                                        (data.errors.unlink_username) ? $('#error_username_unlink').text(data.errors.unlink_username) : $('#error_username_unlink').text('');        
                                }
                                else
                                {
                                        console.log(data);
                                        $('.unlink_username').text('');
                                        // $('#unlink_modal').modal('show');
                                        alert(data.success);
                                }
                        }
                });
        });
});                    

</script>

@stop

