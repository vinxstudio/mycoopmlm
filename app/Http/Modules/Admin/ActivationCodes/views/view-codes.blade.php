@extends('layouts.master')
@section('content')
    <a href="{{ url('admin/activation-codes') }}" class="btn btn-link"><i class="fa fa-arrow-left"></i> back</a>
    <br/>
    <div class="col-md-12"  id="codelist">
        {{ view('widgets.activationCodes.list')->with([
            'codes'=>$codes
        ])->render() }}
        {{ $codes->render() }}
    </div>
    @include('Admin.ActivationCodes.views.delete-code')
@stop
