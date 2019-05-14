@extends('layouts.members')
@section('content')
    <div class="col-md-12 col-xs-12">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">Savings Details</h3>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body no-padding">      
            <div class="form-group">
                <div class="col-sm-12">
                    <label class="col-sm-6 control-label">Type</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="{{ $type }}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Last Name</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="{{ $last_name }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">First Name</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="{{ $first_name }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Middle Name</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="{{ $middle_name }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Birthdate</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="{{ $birthdate }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Contact Number</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="{{ $contact_number }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Home Address</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="{{ $home_address }}" />
                </div>
            </div>
        </div>
    </div>
@stop