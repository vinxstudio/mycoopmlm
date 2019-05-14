@extends('layouts.members')
@section('content')
    <div class="col-md-6 col-xs-12" >
    	<img width="400" @if(isset($image_banner_path)) src="{{ $image_banner_path }}" @endif>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">Purchase Damayan</h3>
            </div>

            <div class="clearfix"></div>
        </div><!-- /.panel-heading  -->
        <div class="panel-body no-padding">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            {{ Form::open([ 'url'=> 'member/programServices/damayan/store']) }}
                <input type="hidden" class="form-control"  name="cost" value="{{ $cost }}" />
                {{ $errors->first('type') }}
                @foreach($types as $key => $type)
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label class="col-sm-6 control-label">{{ $type }}</label>
                            <div class="col-sm-3">
                                <input type="radio" class="form-control" name="type" value="{{ $key }}" />
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="form-group">
                    {{ $errors->first('last_name') }}
                    <label class="col-sm-4 control-label">Last Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control"  name="last_name" value="{{ old('last_name') }}" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ $errors->first('first_name') }}
                    <label class="col-sm-4 control-label">First Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control"  name="first_name" value="{{ old('first_name') }}" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ $errors->first('middle_name') }}
                    <label class="col-sm-4 control-label">Middle Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control"  name="middle_name" value="{{ old('middle_name') }}" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ $errors->first('birthdate') }}
                    <label class="col-sm-4 control-label">Birthdate</label>
                    <div class="col-sm-7">
                        <input type="date" class="form-control"  name="birthdate" value="{{ old('birthdate') }}" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ $errors->first('beneficiary') }}
                    <label class="col-sm-4 control-label">Beneficiary</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control"  name="beneficiary" value="{{ old('beneficiary') }}" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ $errors->first('address') }}
                    <label class="col-sm-4 control-label">Address</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control"  name="address" value="{{ old('address') }}" required="" />
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::button('Purchase', [
                            'type'=>'submit',
                            'value'=>'Purchase',
                            'class'=>'btn btn-success pull-right mr-20'
                        ]) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop