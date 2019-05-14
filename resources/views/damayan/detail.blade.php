@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 70%;">
            <div class="row py-3 text-center align-items-center">
                <div class="col-sm-12">
                    <div class="row align-items-center">
                        <div class="col text-sm-right">
                            <span class="p-0 fa-layers fa-3x">
                                <i class="fas fa-male" data-fa-transform="shrink-2 right-4"></i>
                                <i class="fas fa-male" data-fa-transform="shrink-5 right-7"></i>
                                <i class="fas fa-male"></i>
                                <i class="fas fa-male" data-fa-transform="shrink-2 left-4"></i>
                                <i class="fas fa-male" data-fa-transform="shrink-5 left-7"></i>
                            </span>
                        </div>
                        <div class="col-sm-12">
                            <span class="h3">DAMAYAN MORTUARY PROGRAM</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 p-5 text-center grey bg mb-5" style="background-color: #d2d2d2;">
            
                <img src="{{ asset('public/program_services/logo-big.png') }}" alt="">
                <div class="h4 mt-3">DAMAYAN MORTUARY PROGRAM</div>
                <div class="h4 mb-5">APPLICATION FORM</div>
                <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <label class=""><strong>Type</strong></label>
                        <input class="form-control" value="{{ $type_string }}" disabled="" />
                    </div>
                    <div class="col-sm-2">
                        <label class=""><strong>Age Range</strong></label>
                        <input class="form-control" value="{{ $range_details }}" disabled="" />
                    </div>
                    <div class="col-sm-2">
                        <label class=""><strong>Amount</strong></label>
                        <input class="form-control" value="{{ $cost }}" disabled="" />
                    </div>
                    <div class="col-sm-5"></div>
                </div>
                @if(session()->has('message'))
                <div class="form-group row m-5">
                    <div class="col text-sm-left alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                </div>
                @endif
                <div class="form-group row m-5">
                    <div class="col-md-4 text-sm-left">
                        <label class="control-label">Filed Date</label>
                        <input disabled="" class="form-control"  value="{{ $created_at }}" />
                    </div>
                </div>
                <div class="form-group row m-5">
                    <div class="col-sm-4 text-sm-left">
                        <label class="">Surname</label>
                        <input disabled="" class="form-control" value="{{ $last_name }}"/>
                    </div>
                    <div class="col-sm-4 text-sm-left">
                        <label class="">First Name</label>
                        <input disabled="" class="form-control" value="{{ $first_name }}"/>
                    </div>
                    <div class="col-sm-4 text-sm-left">
                        <label class="">Middle Name</label>
                        <input disabled="" class="form-control" value="{{ $middle_name }}"/>
                    </div>
                </div>
                <div class="form-group row m-5">
                    <div class="col-sm-12 text-sm-left">
                        <label class="">Address</label>
                        <input disabled="" class="form-control" value="{{ $address }}" />
                    </div>
                </div>
                <div class="form-group row m-5">
                    <div class="col-sm-6 text-sm-left">
                        <label class="">Birthdate</label>
                        <input disabled="" class="form-control" value="{{ $birthdate }}"/>
                    </div>
                    <div class="col-sm-6 text-sm-left">
                        <label class="">Beneficiary</label>
                        <input disabled="" class="form-control" value="{{ $beneficiary }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-sm-left">
                        <small class="red">****I agree for the yearly renewal of this Damayan Mortuary Program</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop