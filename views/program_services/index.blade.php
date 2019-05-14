@extends('layouts.members')
@section('content')
    <div class="col-md-12 col-xs-12">
        <center>Programs</center>

        @foreach($programs as $progam)
        	<div class="col-md-3 col-xs-3">
        		<div class="card" style="width: 18rem;">
				  <a href="programServices/{{$progam->slug}}">
                    <img width="50px" class="card-img-top" src="{{ $progam->image_icon_path }}" alt="{{ $progam->name }}">
				        <h5 class="card-title">{{ $progam->name }}</h5>
                </a>
				</div>
        	</div>
        @endforeach
    </div>
    <div class="col-md-12 col-xs-12">
        <center>Services Offered</center>

        @foreach($services as $service)
        	<div class="col-md-2 col-xs-2">
        		<div class="card" style="width: 18rem;">
				    <a href="programServices/{{$service->slug}}">
                        <img width="50px" class="card-img-top" src="{{ $service->image_icon_path }}" alt="{{ $service->name }}">
    				    <h5 class="card-title">{{ $service->name }}</h5>
                    </a>
				</div>
        	</div>
        @endforeach
    </div>
@stop