@extends('layouts.members')
@section('content')
    @if (config('system.slot_buying') == TRUE_STATUS)
    <a class="btn btn-primary pull-left" href="{{ url('member/investments/buy') }}">{{ Lang::get('investments.buy') }} {{ $buyAmount}} <i class="fa fa-money"></i></a>
    @endif
    <div class="clearfix"></div><br/>
    <div class="col-md-12 col-xs-12 row pull-left">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('investments.purchased') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                {{ view('widgets.activationCodes.list')->with([
                    'codes'=>$purchased
                ]) }}
            </div>
        </div>
    </div>
    <div class="row col-md-12 col-xs-12 pull-left">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <th>{{ Lang::get('investments.account_id') }}</th>
                <th>{{ Lang::get('investments.sponsor') }}</th>
                <th>{{ Lang::get('investments.upline') }}</th>
                <th>{{ Lang::get('investments.node') }}</th>
                <th>{{ Lang::get('investments.earned') }}</th>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->code->account_id }}</td>
                        <td>{{ $account->sponsor_id }}</td>
                        <td>{{ @$account->upline->code->account_id }}</td>
                        <td>{{ strtoupper($account->node) }}</td>
                        <td>{{ number_format($account->totalEarned, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop