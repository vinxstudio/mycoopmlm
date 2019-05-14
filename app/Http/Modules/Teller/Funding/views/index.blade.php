@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-theme rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ Lang::get('funding.add_funds') }}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <br/>
                    {{ Form::open([ 'class'=>'form-inline' ]) }}
                    <div class="form-body">
                        <div class="col-md-12 row">
                            <div class="form-group">
                                {{ validationError($errors, 'member') }}
                                <label class="control-label">{{ Lang::get('funding.select_member') }}</label>
                                {{ Form::select('member', [''=>Lang::get('funding.select_member')] + $members, old('member'), [
                                    'class'=>'form-control chosen-select'
                                ]) }}
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="form-group">
                                {{ validationError($errors, 'amount') }}
                                <label class="col-sm-12 control-label">{{ Lang::get('labels.amount') }}</label>
                                <input type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=""></label><br/>
                            <button type="submit" name="save" value="save" class="btn btn-success">{{ Lang::get('funding.add_funds') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>
            </div>
        </div>


        <div class="col-md-12 col-xs-12">
            <div class="panel panel-theme rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{ Lang::get('funding.history') }}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <th>{{ Lang::get('labels.member') }}</th>
                            <th>{{ Lang::get('labels.account') }}</th>
                            <th>{{ Lang::get('labels.amount') }}</th>
                            <th>{{ Lang::get('labels.action') }}</th>
                        </thead>
                        <tbody>
                            @forelse($history as $funding)
                                <tr>
                                    <td>{{ $funding->account->user->details->fullName }}</td>
                                    <td>{{ $funding->account->code->account_id }}</td>
                                    <td>{{ number_format($funding->amount, 2) }}</td>
                                    <td>
                                        <a class="btn btn-danger btn-xs" href="{{ url('admin/funding/delete/'.$funding->id) }}">{{ Lang::get('labels.delete') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <center><i>No records found.</i></center>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop