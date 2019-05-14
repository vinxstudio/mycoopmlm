@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 60%;">
            <div class="row py-3 align-items-center">
                <div class="col text-center mb-20">
                    <i class="fas fa-suitcase fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">ETours</span>
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
                            <div class="col-md-4">
                                <label class="control-label">Data Filed</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->created_at }}" />
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Status</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $status_string }}" />
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Type</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->type_string }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">City/Destination</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->destination }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">Check In</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->checkin }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <label class="control-label">Check Out</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->checkout }}" />
                            </div>
                        </div>
                        <div class="form-group row text-sm-left">
                            <div class="col">
                                <label class="control-label">Adults</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->adults }}" />
                            </div>
                            <div class="col">
                                <label class="control-label">Kids</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->kids }}" />
                            </div>
                            <div class="col">
                                <label class="control-label">Infants</label>
                                <input class="form-control" disabled="" type="text"  value="{{ $data->infants }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop