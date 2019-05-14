@extends('layouts.members')
@section('content')
<div class="body-container bg-light" >
    <div class="content-wrapper row">
        <div style="margin: 0 auto; width: 60%;">
            <div class="row py-3 align-items-center">
                <div class="col">
                    <a class="text-dark"  href="{{ URL::to('member/programServices') }}" >
                        <i class="fas fa-arrow-left fa-fw fa-2x align-middle fa-pull-left"></i>
                        <span class="h4 align-middle">Program and Services</span>
                    </a>
                </div>
                <div class="col-sm-8 text-center">
                    <i class="fas fa-briefcase fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">Savings</span>
                </div>
                <div class="col"></div>
            </div>
            <div class="row py-3 align-items-center">
                <div class="col-md-5">
                    <img @if(isset($image_banner_path)) src="{{ $image_banner_path }}" @endif alt="">
                </div>
                <div class="col-md-7 text-center">
                    <div class="panel-body no-padding">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        {{ Form::open([ 'url'=> 'member/programServices/savings/store']) }}
                            <em style="color:red;">{{ $errors->first('types') }}</em>
                            @foreach($types as $key => $type)
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-6 control-label">{{ $type }}</label>
                                        <div class="col-sm-3">
                                            <input type="checkbox" class="form-control" name="types[{{ $key }}]" value="{{ $key }}" />
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" step="any" class="form-control" name="amounts[{{ $key }}]"/>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('last_name') }}</em>
                                <label class="col-sm-4 control-label">Last Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control"  name="last_name" value="{{ old('last_name', $user->last_name) }}" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('first_name') }}</em>
                                <label class="col-sm-4 control-label">First Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control"  name="first_name" value="{{ old('first_name', $user->first_name) }}" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('middle_name') }}</em>
                                <label class="col-sm-4 control-label">Middle Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control"  name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('birthdate') }}</em>
                                <label class="col-sm-4 control-label">Birthdate</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control"  name="birthdate" value="{{ old('birthdate') }}" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('contact_number') }}</em>
                                <label class="col-sm-4 control-label">Contact Number</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control"  name="contact_number" value="{{ old('contact_number') }}" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('home_address') }}</em>
                                <label class="col-sm-4 control-label">Home Address</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control"  name="home_address" 
                                        value="{{ old('home_address', $user->present_street.' '.$user->present_barangay.' '.$user->present_town.' '.$user->present_city.' '.$user->present_province) }}" 
                                        required="" />
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::button('Transfer to Savings', [
                                        'type'=>'submit',
                                        'value'=>'Purchase',
                                        'class'=>'btn rounded-0 orange bg my-5'
                                    ]) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop