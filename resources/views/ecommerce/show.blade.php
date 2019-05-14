@extends('layouts.members')
@section('plugin_css')
	<link rel="stylesheet" href="{{ asset('public/assets/member/css/style.css') }}">
@stop
@section('content')
<div class="content row p-4 w-75 m-auto">
	<div class="col p-3 bg-white">
		<img class="w-100" src="{{ asset('public/products/'.$image) }}" alt="">
	</div>

	<div class="col ml-3 p-3 bg-white prod-detail">
		<div class="alert alert-success fade in" style="display: none;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  	<strong>Success!</strong> Product added to cart.
		</div>

		<div class="alert alert-danger fade in" style="display: none;">
		 	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		 	<strong>Error!</strong> Product not added to cart.
		</div>
		

		<h3 class="h2">{{ $category_string }}</h3>
		<h2 class="display-4">{{ $name }}</h2>
		<p class="price my-5">SRP: Php. {{ number_format($price, 2) }}</p>
		<p class="price my-5">MP: Php. {{ number_format($rebates, 2) }}</p>
		<hr class="my-5">
		<div class="input-group w-50 m-auto">
			<label class="h5" for="">Quantity</label>
			<div class="input-group-prepend ml-3">
				<button class="btn rounded-0" type="button" id="decreaseQuantity">
				<i class="fas fa-minus fa-lg"></i></button>
			</div>
			<input type="number" min="1" step="1" class="form-control rounded-0" id="productQuantity" value="1">
			<div class="input-group-append">
				<button class="btn rounded-0" type="button" id="increaseQuantity">
				<i class="fas fa-plus fa-lg"></i></button>
			</div>
		</div>
		<div class="row w-75 m-auto">
			<div class="col my-3">
				<button type="button" class="w-100 p-3 btn rounded-0 blue bg" value="{{$slug}}" id="btnAddToCart">
					ADD TO SHOPPING CART <i class="fas fa-shopping-cart fa-lg fa-inverse"></i>
				</button>
			</div>
			<div class="col my-3">
				<button class="w-100 p-3 btn rounded-0 orange bg" type="button" value="{{$slug}}"  id="btnBuyNow">BUY NOW</button>
			</div>
		</div>
	</div>
	<div class="col-12 mt-3 p-3 bg-white">{{ $description }}</div>
</div>
@stop
@section('plugin_js')
<script src="{{ asset('public/assets/member/js/product_show.js') }}"></script>
@stop