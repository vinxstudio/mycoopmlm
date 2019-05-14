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
                    <i class="fas fa-suitcase fa-fw fa-3x align-middle"></i>
                    <span class="h3 align-middle">ETours</span>
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
                        {{ Form::open([ 'url'=> 'member/programServices/etours/store']) }}
                            <em style="color:red;">{{ $errors->first('type') }}</em>
                            <div class="form-group row text-sm-left"> 
                                @foreach($types as $key => $type)
                                    <div class="col-sm-6">
                                        <label>{{ $type }}</label>
                                        <input type="radio" name="type" value="{{ $key }}" checked="" />
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('destination') }}</em>
                                <label>City/Destination</label>
                                <input type="text" class="form-control"  name="destination" value="{{ old('destination') }}" required="" />
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('checkin') }}</em>
                                <label>Check In</label>
                                <input type="date" class="form-control"  name="checkin" value="{{ old('checkin') }}" required="" />
                            </div>
                            <div class="form-group row">
                                <em style="color:red;">{{ $errors->first('checkout') }}</em>
                                <label>Check Out</label>
                                <input type="date" class="form-control"  name="checkout" value="{{ old('checkout') }}" required="" />
                            </div>
                            <div class="form-group row text-sm-left">
                                <div class="col">
                                    <label>Adults</label>
                                    <input type="number" class="form-control"  name="adults" value="{{ old('adults') }}" required="" min="0" placeholder="0" />
                                </div>
                                <div class="col">
                                    <label>Kids</label>
                                    <input type="number" class="form-control"  name="kids" value="{{ old('kids') }}" required="" min="0" placeholder="0" />
                                </div>
                                <div class="col">
                                    <label>Infants</label>
                                    <input type="number" class="form-control"  name="infants" value="{{ old('infants') }}" required="" min="0" placeholder="0" />
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::button('Purchase', [
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