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
                <?php
                    // echo "<pre>";
                    // print_r($member->membership->membership_type_name);
                    // die;
                ?>
                    <tr>
                        <td class="hidden-xs"><img src="{{ url($member->details->thePhoto) }}" class="img-circle" width="40" height="40" alt=""/></td>
                        <td>{{ $member->details->fullName or '' }}</td>
                        <td class="hidden-xs">{{ $member->username or '' }}</td>
                        <td class="hidden-xs"><a href="{{ url(sprintf('auth/sign-up?ref=%s', isset($member->account->code->account_id) ? $member->account->code->account_id : null)) }}" target="_blank">{{ sprintf('?ref=%s', isset($member->account->code->account_id) ? $member->account->code->account_id : '') }}</a></td>
                        <td class="hidden-xs">{{ $member->account->uplineUser->username or '' }} <br/> {{ (isset($member->account->uplineUser->id)) ? sprintf('(%s)', strtoupper($member->account->uplineUser->account->code->account_id)) : null }}</td>
                        <td class="hidden-xs">{{ $member->membership->membership_type_name }}</td>
                        <td class="hidden-xs">{{ $member->membership->entry_fee }}</td>
                        @if ($company->multiple_account > 0)
                            <td class="hidden-xs">{{ strtoupper(@$member->account->code->account_id) }}</td>
                        @endif
                        <td class="hidden-xs">{{ number_format($member->earnings, 2) }}</td>
                        @if ($company->multiple_account <= 0)
                            <td class="hidden-xs">{{ $member->accounts->count() }}</td>
                        @endif
                        <td class="hidden-xs">{{ $member->directReferral->count() }}</td>
                        <td>
                            <a class="btn btn-warning btn-xs" href="{{ url('admin/members/form/'.$member->id) }}"><i class="fas fa-edit"></i> Edit</a>
                            <a class="btn btn-danger btn-xs" href="{{ url('admin/members/login/'.$member->id) }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                            <a class="btn btn-success btn-xs" href="{{ url('admin/export-file/xlsx/'.$member->user_details_id) }}"><i class="fas fa-download"></i> Download</a>
                        </td>
                    </tr>
                @endforeach
            @endif

        </tbody>

    </table>
    {{ $members->render() }}
@stop
