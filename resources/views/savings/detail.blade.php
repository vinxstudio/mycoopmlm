@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 60%;">
            <div class="row py-3 align-items-center">
                <div class="col text-center mb-20">
                    <i class="fas fa-briefcase fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">Savings</span>
                </div>
            </div>
            <div class="row py-3 align-items-center m-5">
                <div class="col-md-5 text-center">
                    <img width="90%" @if(isset($image_banner_path)) src="{{ $image_banner_path }}" @endif alt="">
                </div>
                <div class="col-md-7 text-center">
                    <div class="panel-body no-padding">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="form-group row mt-20">
                            <div class="col-md-4">
                                <label class="control-label">Date Filed</label>
                                <input disabled="" class="form-control"  value="{{ $data->created_at }}" />
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Amount</label>
                                <input disabled="" class="form-control" value="{{ $data->amount }}" />
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Type</label>
                                <input disabled="" class="form-control" value="{{ $data->type_string }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label">Last Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->last_name }}" />
                        </div>
                        <div class="form-group row">
                            <label class="control-label">First Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->first_name }}" />
                        </div>
                        <div class="form-group row">
                            <label class="control-label">Middle Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->middle_name }}" />
                        </div>
                        <div class="form-group row">
                            <label class="control-label">Birthdate</label>
                            <input disabled="" class="form-control"  value="{{ $data->birthdate }}"/>
                        </div>
                        <div class="form-group row">
                            <label class="control-label">Contact Number</label>
                            <input disabled="" class="form-control"  value="{{ $data->contact_number }}"/>
                        </div>
                        <div class="form-group row">
                            <label class="control-label">Home Address</label>
                            <input disabled="" class="form-control"  value="{{ $data->home_address }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop