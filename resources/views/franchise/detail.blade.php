@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 60%;">
            <div class="row py-3 align-items-center">
                <div class="col text-center mb-20">
                    <i class="fas fa-handshake fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">Franchise</span>
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
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Filed Date</label>
                                <input disabled="" class="form-control"  value="{{ $data->created_at }}" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Status</label>
                                <input disabled="" class="form-control"  value="{{ $status_string }}" />
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label">Last Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->last_name }}" />
                        </div>
                        <div class="row">
                            <label class="control-label">First Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->first_name }}" />
                        </div>
                        <div class="row">
                            <label class="control-label">Middle Name</label>
                            <input disabled="" class="form-control"  value="{{ $data->middle_name }}" />
                        </div>
                        <div class="row">
                            <label class="control-label">Birthdate</label>
                            <input disabled="" class="form-control"  value="{{ $data->birthdate }}"/>
                        </div>
                        <div class="row">
                            <label class="control-label">Contact Number</label>
                            <input disabled="" class="form-control"  value="{{ $data->contact_number }}"/>
                        </div>
                        <div class="row">
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