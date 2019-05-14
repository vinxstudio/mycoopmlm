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
                    <i class="fas fa-building fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">eHotel</span>
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
                        {{ Form::open([ 'url'=> 'member/programServices/eHotel/store']) }}
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('destination') }}</em>
                                <div class="col">
                                    <label class="">City, destination, or hotel name</label>
                                    <input type="text" class="form-control"  name="destination" value="{{ old('destination', $user->destination) }}" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('check_in') }}</em>
                                <div class="col">
                                    <label class="">Check In</label>
                                    <input type="date" class="form-control"  name="check_in" value="{{ old('check_in', $user->check_in) }}" required="" />
                                </div>
                                <em style="color:red;">{{ $errors->first('check_out') }}</em>
                                <div class="col">
                                    <label class="">Check Out</label>
                                    <input type="date" class="form-control"  name="check_out" value="{{ old('check_out', $user->check_out) }}" required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col"></div>
                                <em style="color:red;">{{ $errors->first('guest') }}</em>
                                <div class="col-sm-4">
                                    <label class="">Guest</label>
                                    <input type="number" step="1" min="0" class="form-control"  name="guest" value="{{ old('guest') }}" required="" />
                                </div>
                                <em style="color:red;">{{ $errors->first('room') }}</em>
                                <div class="col-sm-4">
                                    <label class="">Room</label>
                                    <input type="text" class="form-control"  name="room" value="{{ old('room') }}" required="" />
                                </div>
                                <div class="col"></div>
                            </div>
                            <div class="form-group">
                                {{ Form::button('Book a Room', [
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