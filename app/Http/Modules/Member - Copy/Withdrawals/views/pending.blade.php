@extends('layouts.members')
@section('content')
    <div class="col-md-12 col-xs-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('withdrawal.pending') }}</h3>
                <div class="clearfix"></div>
            </div>
        </div>

        {{ view('widgets.withdrawals.table_widget')->with([
                    'withdrawals'=>$withdrawals
                ])->render() }}

        <center>{{ $withdrawals->render() }}</center>
    </div>
@stop