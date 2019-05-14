@extends('layouts.members')
@section('plugin_css')
	<link rel="stylesheet" href="{{ asset('public/assets/member/css/style.css') }}">
@stop
@section('content')
<div class="content wrapper row">
	<div class="col bg-white my-3 p-3">
		<div class="alert alert-success fade in" style="display: none;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  	<strong>Success!</strong> Cart updated.
		</div>

		<div class="alert alert-danger fade in" style="display: none;">
		 	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		 	<strong>Error!</strong> Cart not updated.
		</div>

		<table class="table responsive fixed checkout">
			<thead>
				<tr>
					<th scope="col" class="p-name">Product</th>
					<th scope="col" class="price">Unit Price</th>
					<th scope="col" class="qty">Quantity</th>
					<th scope="col" class="tprice">Total Price</th>
					<th scope="col" class="act">Actions</th>
				</tr>
			</thead>
			<tbody>
				@if(Session::has('cart'))
					@foreach($products as $slug => $product)
						<tr id="product_{{ $slug }}">
							<td>
								<div class="row">
									<div class="col text-left">
										<img width="100px" class="float-sm-left mr-3" 
											src="{{ asset('public/products/'.$product['image']) }}" 
											alt="">
										<p class="h3">{{ $product['name'] }}</p>
										<input type="hidden" class="productSlugs" value="{{ $slug }}">
									</div>
								</div>
							</td>
							<td id="product_{{ $slug }}_unit_price" value="{{ $product['member_price'] }}"><strong class="productUnitPrices">P {{ $product['member_price'] }}</strong></td>
							<td>
								<div class="input-group">
									<div class="input-group-prepend">
										<button class="btn rounded-0 btnDecreaseQuantity" type="button" value="{{ $slug }}">
										<i class="fas fa-minus fa-lg"></i></button>
									</div>
									<input type="number" step="1" class="form-control rounded-0 productQuantities" id="product_{{ $slug }}_quantity" value="{{ $product['quantity'] }}">
									<div class="input-group-append">
										<button class="btn rounded-0 btnIncreaseQuantity" type="button" value="{{ $slug }}">
										<i class="fas fa-plus fa-lg"></i></button>
									</div>
								</div>
							</td>
							<td>
								<strong class="orange productPrices" id="product_{{ $slug }}_total_price">P {{ $product['member_price'] * $product['quantity']}}</strong>
							</td>
							<td>
								<button class="btnRemoveFromCart" value="{{ $slug }}"><i class="fas fa-times fa-lg"></i></button>
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
	<div class="col-12 text-center">
		<div class="row bg-white my-3 p-3">
			<div class="col-sm-3">
				<a href="{{ URL::to('member/programServices/eCommerce') }}" >
					<button type="button" class="w-100 p-3 btn rounded-0 blue bg">
						CONTINUE SHOPPING<i class="fas fa-shopping-cart fa-lg pull-right fa-inverse"></i>
					</button>
				</a>
			</div>
			<div class="col-sm-7 text-sm-right">
				<p class="m-0">Merchandise Subtotal (<span>{{sizeOf($products)}} items</span>):
					<strong class="h1 orange" id="divCartTotalCost">₱ 0.00</strong>
				</p>
			</div>
			<div class="col-sm-2">
				<a href="{{ URL::to('member/cart/placeOrder') }}" >
					<button type="button" class="w-100 p-3 btn rounded-0 orange bg">
						CHECK OUT
					</button>
				</a>
			</div>
		</div>
	</div>
</div>
@stop
@section('plugin_js')
	<script src="{{ asset('public/assets/member/js/cart.js') }}"></script>
@stop