@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 70%;">
            <div class="row py-3 text-center align-items-center">
                <div class="col text-sm-left">
                    <a class="text-dark"  href="{{ URL::to('member/programServices') }}" >
                        <i class="fas fa-arrow-left fa-fw fa-2x align-middle fa-pull-left"></i>
                        <span class="h4 align-middle">Program and Services</span>
                    </a>
                </div>
                <div class="col-sm-8">
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
                        <div class="col-sm-8 text-sm-left">
                            <span class="h3">DAMAYAN MORTUARY PROGRAM</span>
                        </div>
                    </div>
                </div>
                <div class="col text-sm-right">
                    <a class="text-dark" href=""><i class="fas fa-download fa-fw fa-2x"></i></a>
                    <a class="text-dark" href=""><i class="fas fa-print fa-fw fa-2x"></i></a>
                </div>
            </div>
            <div class="col-12 p-5 text-center grey bg mb-5" style="background-color: #d2d2d2;">
                {{ Form::open([ 'url'=> 'member/programServices/damayan/store']) }}
                    <img src="{{ asset('public/program_services/logo-big.png') }}" alt="">
                    <div class="h4 mt-3">DAMAYAN MORTUARY PROGRAM</div>
                    <div class="h4 mb-5">APPLICATION FORM</div>
                    <div class="row mb-3">
                        <div class="col text-center">
                            @foreach($types as $key => $type)
                                <div class="form-check form-check-inline">
                                    {{ $errors->first('type') }}
                                    <input class="form-check-input" type="radio" class="form-control" name="type" value="{{ $key }}" checked="" />
                                    <label class="form-check-label"><strong>{{ $type }}</strong></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col text-center">
                            @foreach($ranges as $key => $range)
                                <div class="form-check form-check-inline">
                                    {{ $errors->first('range') }}
                                    <input class="form-check-input" type="radio" class="form-control" name="age_range" value="{{ $key }}" checked="" />
                                    <label class="form-check-label"><strong>{{ $range['details'] }} {{ $range['amount'] }}</strong></label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row pt-3 mb-5">
                        <div class="col text-left">
                            <ul class="mt-4">
                                <li>If Enrollee is between 18-60 years old.</li>
                                <li>For the immediate beneficiary of a regular member, must have least<br>One (1) Share Capital contribution or an initial  Share Capital of Php 500.00.</li>
                                <li>Memorial Services Package:
                                    <ul>
                                        <li>Pick-up Cadaver</li>
                                        <li>Embalming good for 9 days</li>
                                        <li>Delivery of casketed cadaver</li>
                                        <li>Home viewing for 9 days</li>
                                        <li>Burial arrangement</li>
                                        <li>Interment</li>
                                        <li>1 wreath flower arrangement (Standard)</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row pt-3 mb-5">
                        <div class="col text-left">
                            <ul class="mt-4">
                                <li>If Enrollee is between 61 - 68 years old.</li>
                                <li>For the immediate beneficiary of a regular member, must have least<br>One (1) Share Capital contribution or an initial  Share Capital of Php 500.00.</li>
                                <li>For EXISTING MEMBERS aging 65 – 68 years old  (no contestability)</li>
                                <li>For NEW MEMBERS aging 61 years old to 68 years old  ( 6 months contestability).</li>
                                <li>Memorial Services Package:
                                    <ul>
                                        <li>Pick-up Cadaver</li>
                                        <li>Embalming good for 9 days</li>
                                        <li>Delivery of casketed cadaver</li>
                                        <li>Home viewing for 9 days</li>
                                        <li>Burial arrangement</li>
                                        <li>Interment</li>
                                        <li>1 wreath flower arrangement (Standard)</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if(session()->has('message'))
                    <div class="form-group row">
                        <div class="col text-sm-left alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <div class="col text-sm-left">
                            <label class="">Surname <em style="color:red;">{{ $errors->first('last_name') }}</em></label>
                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">First Name <em style="color:red;">{{ $errors->first('first_name') }}</em></label>
                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}" required="" />
                        </div>
                        <div class="col text-sm-left">
                            <label class="">Middle Name <em style="color:red;">{{ $errors->first('middle_name') }}</em></label>
                            <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 text-sm-left">
                            <label class="">Address <em style="color:red;">{{ $errors->first('address') }}</em></label>
                            <input type="text" class="form-control" name="address" 
                                    value="{{ old('address', $user->present_street.' '.$user->present_barangay.' '.$user->present_town.' '.$user->present_city.' '.$user->present_province) }}"  
                                    required="" />
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 text-sm-left">
                            <label class="">Birthdate <em style="color:red;">{{ $errors->first('birthdate') }}</em></label>
                            <input type="date" class="form-control" name="birthdate" value="{{ old('birthdate') }}" required="" />
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 text-sm-left">
                            <label class="">Beneficiary <em style="color:red;">{{ $errors->first('beneficiary') }}</em></label>
                            <input type="text" class="form-control" name="beneficiary" value="{{ old('beneficiary') }}" required="" />
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row py-3 my-5">
                        <div class="col"></div>
                        <div class="col-sm-4">
                            {{ Form::button('Purchase', [
                                    'type'=>'submit',
                                    'value'=>'Purchase',
                                    'class'=>'btn rounded-0 orange bg'
                                ]) }}
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row">
                        <div class="col text-sm-left">
                            <small class="red">****I agree for the yearly renewal of this Damayan Mortuary Program</small></p>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop