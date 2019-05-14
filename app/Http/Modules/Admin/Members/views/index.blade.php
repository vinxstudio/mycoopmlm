@extends('layouts.master')
@section('content')

    <a class="btn btn-primary pull-left" href="{{ url('admin/members/form') }}"><i class="fa fa-plus"></i> {{ Lang::get('labels.new') }}</a>
    <div class="clearfix"></div>
    <br/>
    {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
        <div class="pull-right">
            <div class='col-md-3'>
                <div class="form-group">
                    <div class='input-group date'>
                        <span class="input-group-addon">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type='text' name="search_keyword" class="form-control" value="{{ $search_keyword }}" />
                    </div>
                </div>
            </div>
            <div class='col-md-3'>
                <div class="form-group">
                    <div class='input-group date'>
                        <input type='submit' class="form-control btn btn-primary" value="SEARCH"  />
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class="form-group">
                    <a class="btn btn-success pull-right" href="{{ url('admin/export-file/xlsx/0') }}"><i class="fas fa-download"></i> Download All Members Info</a>
                </div>
            </div>
        </div>
    {{ Form::close() }}
    
    <table class="1dataTable table table-bordered table-hover table-striped">

        <thead>
            <th class="hidden-xs">{{ Lang::get('members.photo') }}</th>
            <th>{{ Lang::get('members.name') }}</th>
            <th class="hidden-xs">{{ Lang::get('members.username') }}</th>
            <th class="hidden-xs">{{ Lang::get('members.referral_link') }}</th>
            <th class="hidden-xs">{{ Lang::get('members.upline') }}</th>
            <th class="hidden-xs">{{ Lang::get('members.package_name') }}</th>
            <th class="hidden-xs">{{ Lang::get('members.package_amount') }}</th>
            @if ($company->multiple_account > 0)
                <th class="hidden-xs">{{ Lang::get('members.id') }}</th>
            @endif
            <th class="hidden-xs">{{ Lang::get('members.earned') }}</th>
            @if ($company->multiple_account <= 0)
                <th class="hidden-xs">{{ Lang::get('members.accounts_owned') }}</th>
            @endif
            <th class="hidden-xs">{{ Lang::get('members.direct_referral') }}</th>
            <th>{{ Lang::get('labels.action') }}</th>
        </thead>

        <tbody>


            @if ($members->isEmpty())
                <tr>
                    <td colspan="10"><center>{{ Lang::get('members.no_records') }}</center></td>
                </tr>
            @else
                @foreach ($members as $member)
                    <tr>
                        <td class="hidden-xs"><img src="{{ url(isset($member->details->thePhoto) ? $member->details->thePhoto : '') }}" class="img-circle" width="40" height="40" alt=""/></td>
                        <td>{{ $member->details->fullName or '' }}</td>
                        <td class="hidden-xs">{{ $member->username or '' }}</td>
                        <td class="hidden-xs"><a href="{{ url(sprintf('auth/sign-up?ref=%s', isset($member->account->code->account_id) ? $member->account->code->account_id : null)) }}" target="_blank">{{ sprintf('?ref=%s', isset($member->account->code->account_id) ? $member->account->code->account_id : '') }}</a></td>
                        <td class="hidden-xs">{{ $member->account->uplineUser->username or '' }} <br/> {{ (isset($member->account->uplineUser->id)) ? sprintf('(%s)', strtoupper($member->account->uplineUser->account->code->account_id)) : null }}</td>
                        <td class="hidden-xs">{{ $member->membership->membership_type_name or '' }}</td>
                        <td class="hidden-xs">{{ $member->membership->entry_fee or '' }}</td>
                        @if ($company->multiple_account > 0)
                            <td class="hidden-xs">{{ strtoupper(@$member->account->code->account_id) }}</td>
                        @endif
                        <td class="hidden-xs">{{ number_format($member->earnings, 2) }}</td>
                        @if ($company->multiple_account <= 0)
                            <td class="hidden-xs">{{ $member->accounts->count() }}</td>
                        @endif
                        <td class="hidden-xs">{{ $member->directReferral->count() }}</td>
                        <td>
                            <div class="admin-action-buttons">
                                <a class="btn btn-warning btn-xs" id="btn-modal" data-id="{{$member->id}}">
                                    <i class="fas fa-edit"></i> 
                                        Edit
                                    </a>
                                <a class="btn btn-primary btn-xs link-or-unlink" data-username="{{ $member->username }}" data-user-id="{{ $member->id }}" data-group-id="{{ $member->group_id }}">
                                    <i class="fas fa-edit"></i>
                                    Link
                                </a>
                                <a class="btn btn-danger btn-xs" href="{{ url('admin/members/login/'.$member->id) }}">
                                    <i class="fas fa-sign-in-alt"></i> 
                                    Login
                                </a>
                                <a class="btn btn-success btn-xs" href="{{ url('admin/export-file/xlsx/'.$member->user_details_id) }}">
                                    <i class="fas fa-download"></i> 
                                    Download
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>

    </table>
    {{ $members->render() }}

@include('Admin.Members.views.edit_modal')
@include('Admin.Members.views.script')

{{-- modal --}}
<div id="modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">
                    
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert hide modal-alert">

                </div>
                <div class="modal-message">

                </div>

              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-modal-close">
                    Close
                </button>
                <button type="submit" class="btn btn-success update" id="btn-modal-submit">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>

{{-- small modal for confirmation --}}
<div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <div class="alert hide small-modal-alert">

            </div>
            <h4 class="modal-title">
                Confirm
            </h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-confirm">Confirm</button>
        </div>
        </div>
    </div>
</div>



{{-- javascript --}}
<script>

    // variable name is modall
    // when modal is used it throws and exception
    var modall = $('#modal');

    var modal_submit = modall.find('#btn-modal-submit');
    var modal_title = modall.find('.modal-title');
    var modal_body = modall.find('.modal-message');

    // small modal
    var small_modal = $('#confirmation-modal');
    var small_modal_title = small_modal.find('.modal-title');
    var small_modal_body = small_modal.find('.modal-body');
    // var current_page = 1;

    var time_out = '';
    var small_time_out = '';

    var added_user_list = [];

    $(document).ready(function(){

        modall.appendTo('body');

        small_modal.appendTo('body');

        small_modal.modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        // when link or unlink button is click
        $('.link-or-unlink').click(function(){

            let btn_link = $(this);

            let user_id = btn_link.attr('data-user-id');
            let group_id = btn_link.attr('data-group-id');

            let group_head = user_id == group_id;

            console.log(group_head);

            modal_submit.addClass('hide');

            modal_title.text('Linking Member');

            // get all group members
            // get users with the same group_id
            $.ajax({
                url: '/admin/members/group-members',
                method: 'GET',
                dataType: 'JSON',
                data: { group_id: group_id }
            }).done(function(data){

                console.log(data);

                // empty modal body first
                // then add head title
                // then the table
                // then the table data
                modal_body.empty()
                    .append(LinkHeadLayout(data.message.head_name))
                    .append(LinkLayout())
                    .append(LinkMemberLayout(data.message.data, group_head));
                // add user id to array
                data.message.data.forEach(member => {
                    added_user_list.push(member.id);
                });
                // when search form is submitted
                $('.search-user').submit(function(e){
                    e.preventDefault();
                    // search user
                    $.ajax({
                        url: '/admin/members/search-user/',
                        method: 'GET',
                        dataType: 'JSON',
                        data: $(this).serialize()
                    }).done(function(data){

                        console.log(data);

                        // check if id is included in added_user_list
                        if(!added_user_list.includes(data.message.id))
                        {
                            // add if not included
                            added_user_list.push(data.message.id);

                            let link_type = 'link'
                            // show alert info
                            ShowInfo('alert-success', data.message.message);
                            
                            if(group_id == data.message.group_id){
                                link_type = 'unlink';
                            }
                            // add the row
                            $('.table-link-unlink > tbody > tr:first').before(
                                RowLayout(
                                    data.message.photo, 
                                    data.message.fullname, 
                                    data.message.username,
                                    data.message.upline,
                                    link_type,
                                    data.message.id,
                                    group_id,
                                    group_head,
                                    true
                                ));

                            // linked btn
                            ResetBtnLinks(); 

                        }
                        else
                        {
                            ShowInfo('alert-danger', 'Successfully found user but already in the table.');
                        }

                    }).fail(function(data){

                        console.log(data);

                        ShowInfo('alert-danger', data.responseJSON.message);

                    });

                });

                // Reset the button links
                ResetBtnLinks();


            }).fail(function(data){
               
                console.log(data)

                
                ShowInfo('alert-danger', data.responseJSON.message);

            });

            modall.modal('show');

        });

        // when modal is close
        modall.on('hidden.bs.modal', function(){
            
            let modal_alert = $('.modal-alert');

            modal_alert.removeClass('alert-danger');
            modal_alert.removeClass('alert-success');
            modal_alert.addClass('hide');

            modal_body.empty();
            added_user_list = [];

        });

        small_modal.on('hidden.bs.modal', function(){

            small_modal_title.empty();
            small_modal_body.empty();

            // check whether parent modal is opend after child modal close
            if (modall.length) { 
                // if open mean length is 1 then add a bootstrap css class to body of the page
                $('body').addClass('modal-open'); 
            }
        });

        
    });

    // show info function
    function ShowInfo(type, message, small = false)
    {
        let modal_alert = $('.modal-alert');

        if(small)
            modal_alert = $('.small-modal-alert');
        
        // first remove class
        modal_alert.removeClass('alert-success');
        modal_alert.removeClass('alert-danger');
        // then remove message of alert
        // and class
        modal_alert.text(message);
        modal_alert.addClass(type);
        // then remove hide
        modal_alert.removeClass('hide');

        if(small){
            // clear time out 
            // so that it won't stack with the last time out
            clearTimeout(small_time_out);
            // set timeout then assign to time_out variable
            small_time_out = setTimeout(function (){

                modal_alert.addClass('hide');

                modal_alert.removeClass(type);

                modal_alert.empty();

            }, 3000);
        }
        else{
            // clear time out 
            // so that it won't stack with the last time out
            clearTimeout(time_out);
            // set timeout then assign to time_out variable
            time_out = setTimeout(function (){

                modal_alert.addClass('hide');

                modal_alert.removeClass(type);

                modal_alert.empty();

            }, 3000);
        }

    }

    // for when link and unlink button is click
    function LinkedBtn(btn, id, group_id, link_type, row = false){
            
        // let link = true;

        // if(link_type == 'Unlinked')
        //     link = false;

        // update the group id
        $.ajax({
            url: '/admin/members/update-group-id/',
            method: 'POST',
            dataType: 'JSON',
            data: {
                user_id: id,
                group_id: group_id,
                type: link_type
            }
        }).done(function(data){
            
            console.log(data);
            
            ShowInfo('alert-success', data.message, true);

            // if variable row is not undefined or null

            if(row){
                row.remove();

                for(let i = 0; i < added_user_list.length; i++){
                    if(added_user_list[i] == id){
                        added_user_list.splice(i, 1);    
                    }
                }


            }
            else{
                btn.removeClass('btn-primary');
                btn.removeClass('link-button');

                btn.removeClass('unlink-button');
                btn.addClass('btn-danger');

                btn.text('Unlink');
                
                btn.attr('disabled', true);
                // Reset button links;
                // ResetBtnLinks();
            }   


        // when linked button 
        // action fails
        }).fail(function(data){
            
            console.log(data);

            ShowInfo('alert-danger', data.responseJSON.message, true);

        });



    }

    // for head name 
    function LinkHeadLayout(head_name)
    {
        let member_head = '<h4>' +
            head_name +
        '</h4>';
    
        return member_head;
    }

    // form layout function
    function LinkLayout()
    {
        let member_link = '<form class="form-inline search-user" id="search-user">' +
            '<label for="username_input">' +
                'Enter Username' +
            '</label>' +
            '<input type="text" class="form-control mb-2 mr-sm-2" id="username_input" name="username_input" placeholder="Username" />' +
            '<button id="submit_form" type="submit" class="btn btn-primary ml-3 mb-2">' +
                'Submit' +
            '</button>' +
        '</form>';

        return member_link;
    } 
    // for table and table headers
    function LinkMemberLayout(members, group_head)
    {
        let member_table = '<table class="table table-bordered mt-10 table-link-unlink">' +
        '<thead>' +
            '<th width="5%">' +
                '' +
            '</th>' +
            '<th class="col-md-1">' +
                'Name' +
            '</th>' +
            '<th class="col-md-1">' +
                'Username' +
            '</th>' +
            '<th class="col-md-2">' +
                'Upline' +
            '</th>' +
            '<th class="col-sm-1">' +
                'Action' +
            '</th>' +
        '</thead>' +
        '<tbody>';
        // assign table data to table body
        members.forEach(member => {

            member_table += RowLayout(member.photo, 
                member.fullname, 
                member.username, 
                member.upline, 
                'unlink', 
                member.id, 
                member.group_id,
                group_head
            );
            
        });

        member_table += '</tbody>' + 
                        '</table>';

        return member_table;

    }
    // row function for table
    function RowLayout(image, fullname, username, upline, link_type, id, group_id, group_head, is_search = false)
    {

        let row = '<tr>' +
        // photo
        '<td class="text-center">' +
            '<img src="'+ window.location.protocol + '//' + window.location.hostname + '/' + image +'" alt="img" width="30" height="30" class="img-circle"/>' +
        '</td>' +
        // usernmae
        '<td>' +
            fullname +
        '</td>' +
        // upline
        '<td>' +
            username +
        '</td>' +   
        '<td>' +
            '<div class="upline">' +
                upline +
            '</div>'
        '</td>';

        // if(head){
        row += '<td class="text-center">';
        
        let disabled = 'enabled';

        if(link_type == 'link'){
            row += '<button ';

            // if it's head put disabled 
            // ang or is_not search
            if(!group_head || id == group_id && !is_search){
                row += 'disabled ';
            } 
            row +='class="btn btn-primary btn-sm link-button" data-username="' + username + '" data-user-id="'+ id +'" data-group-id="' + group_id + '">Link</button>';
        }
        else if(link_type == 'unlink'){
            row += '<button ';

            // if it's head put disabled 
            // ang or is_not search
            if(!group_head || id == group_id && !is_search){
                row += 'disabled ';
            } 
            row += 'class="btn btn-danger btn-sm unlink-button" data-username="' + username + '" data-user-id="'+ id +'" data-group-id="' + group_id + '">UnLink</button>';
        }
                    
        row += '</td>';
        // }
        // else{
        //     row += '<td></td>';
        // }

        row += '</tr>';
        
        return row;
        
    }

    // reset link button function
    function ResetBtnLinks()
    {

        // linked btn
        $('.link-button').click(function(data){

            let id = $(this).attr('data-user-id');
            let group_id = $(this).attr('data-group-id');
            let username = $(this).attr('data-username');
            // LinkedBtn($(this), id, group_id, 0);

            ShowSmallModalConfirmation($(this), id, group_id, 0, username)

        });

        $('.unlink-button').click(function(){

            let id = $(this).attr('data-user-id');
            let group_id = $(this).attr('data-group-id');
            let username = $(this).attr('data-username');

            let row = $(this).closest('tr');

            //LinkedBtn($(this), id, id, 1, row);

            ShowSmallModalConfirmation($(this), id, id, 1, username, row)

        });
    }

    // small modal confirmation
    function ShowSmallModalConfirmation(btn, user_id, group_id, link, username, row = false)
    {
        
        let confirm_btn = small_modal.find('.btn-confirm');

        let message = 'Confirm ';

        if(link == 0)
            message += 'Linked ';
        else if(link == 1)
            message += 'Unlinked ';

        message += username;

        small_modal_title.empty().text('Confirm');
        small_modal_body.empty().text(message);

        small_modal.modal('show');

        confirm_btn.click(function(){
            LinkedBtn(btn, user_id, group_id, link, row);
        });

    }

</script>

{{-- css style --}}
<style>

    .admin-action-buttons{
        display: block;
        position: relative;
        margin-right: 10px;
        margin-left: 10px;
    }
    .admin-action-buttons a{
        display: block;
        margin-top: 3px;
        margin-bottom: 3px;
    }

    /* margins */

    .mt-10{
        margin-top: 10px;
    }
    .mr-2{
        margin-right: 2px !important;
    }

    .ml-2{
        margin-left: 2px !important;
    }

    .ml-3{
        margin-left: 3px !important;
    }

    .mb-2{
        margin-bottom: 2px !important;
    }

    .form-inline > label{
        display: block;
    }

    /* alert in modal*/
    .modal-message{
        max-width: 100%;
    }

    /* .modal-alert{
        display: inline-block;
        margin-left: 5px;
    } */

    /* table */
    .table-link-unlink{
        min-width: 100% !important;
        width: 100% !important;
        table-layout: fixed;
        
    }
    
    .table-link-unlink tbody > tr > td > .upline{
        display: block;
        position: relative;
        width: calc(100% - 0px);
        word-wrap: normal;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: wrap;
    }


</style>

@stop
