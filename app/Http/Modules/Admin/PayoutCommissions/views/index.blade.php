@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-theme rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ Lang::get('transactions.history') }}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <div class="row col-md-3 pull-right">
                        {{ Form::open() }}
                        <div class="pull-left" style="width:calc(100% - 42px)">
                        {{ Form::select('date', $datesDropdown, '', [
                            'class'=>'form-control'
                        ]) }}
                        </div>
                        {{ Form::button('go', [
                            'type'=>'submit',
                            'value'=>'submit',
                            'class'=>'btn btn-theme pull-left'
                        ]) }}
                        {{ Form::close() }}
                    </div>
                    <div class="col-md-12" style="margin:10px 0"><div class="clearfix"></div></div>
                    <!--table class="dataTable pull-left table table-bordered table-hover table-striped"-->
					<table class="table table-bordered">
                        <thead>
                            <th>{{ Lang::get('transactions.member') }}</th>
                            <th class="text-center">{{ Lang::get('labels.amount') }}</th>
                            <th class="text-center">{{ Lang::get('labels.type') }}</th>
                            <th class="text-center">{{ Lang::get('labels.date') }}</th>
                        </thead>
                        <tbody>
                            @forelse($earnings as $row)
                                @if (isset($row->user->details->id))
                                    <tr>
                                        <td>{{ $row->user->details->fullName }} @if ($row->account->code->account_id) <span class="pull-right">( {{ strtoupper($row->account->code->account_id) }} )</span> @endif</td>
                                        <td class="text-center">{{ number_format($row->amount, 2) }}</td>
                                        <td class="text-center">{{ $row->sourceLabel }}</td>
                                        <td class="text-center">{{ date('F j, Y h:i:sa', strtotime($row->created_at)) }}</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <center><i>{{ Lang::get('messages.no_records_found') }}</i></center>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
					{{ $earnings->render() }}

                </div>
				
            </div>
        </div>
    </div>
@stop