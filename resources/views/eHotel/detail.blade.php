@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 60%;">
            <div class="row py-3 align-items-center">
                <div class="col text-center mb-20">
                    <i class="fas fa-building fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">EHotel</span>
                </div>
            </div>
            <div class="row py-3 align-items-center">
                <div class="col-md-5">
                    <img width="90%" @if(isset($image_banner_path)) src="{{ $image_banner_path }}" @endif alt="">
                </div>
                <div class="col-md-7">
                    <div class="panel-body no-padding">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label class="">Data Filed</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->created_at }}" />
                            </div>
                            <div class="col-md-3">
                                <label class="">Status</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $status_string }}" />
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="">City/Destination</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->destination }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label class="">Check In</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->check_in }}" />
                            </div>
                            <div class="col-md-3">
                                <label class="">Check Out</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->check_out }}" />
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="form-group row text-sm-left">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label class="">Guest</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->guest }}" />
                            </div>
                            <div class="col-md-3">
                                <label class="">Room</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->room }}" />
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop