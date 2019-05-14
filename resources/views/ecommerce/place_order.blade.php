@extends('layouts.members')
@section('plugin_css')
	<link rel="stylesheet" href="{{ asset('public/assets/member/css/style.css') }}">
@stop
@section('content')
{{ Form::open(['method' => 'post', 'url' => 'member/purchases/store']) }}
	<div class="content wrapper row">
		<div class="col-12 bg-white my-3 p-3">
			@if($errors->any())
				<div class="alert alert-danger fade in">
				 	<strong>Error!</strong> {{$errors->first()}}
				</div>
			@endif
			
			<p>Your Account : 
				<strong class="text-uppercase">
					{{ $theDetails->first_name }} {{ $theDetails->last_name }}
				</strong>
			</p>
			<hr>
		</div>
		<div class="col-12 bg-white my-3 p-3">
			<p><strong>Delivery Address</strong></p>
			<hr>
			<p class="ml-5">
				{{ $theDetails->first_name }} {{ $theDetails->last_name }}<br>
				{{ $theDetails->present_barangay }}, {{ $theDetails->present_city }}<br>
				{{ $theDetails->present_province }} {{ $theDetails->present_zipcode }}<br>
			</p>
		</div>
		<div class="col-12 my-4 text-center">
			<span class="h3">Product Ordered</span>
		</div>
		@if(Session::has('cart'))
			<div class="col-12 bg-white my-3 p-3">
				@foreach($products as $slug => $product)
					<div class="row text-center">
						<div class="col-sm-10 text-sm-left">
							<img class="float-sm-left mr-3" width="200px" src="{{ asset('public/products/'.$product['image']) }}" alt="">
							<p class="h3">{{ $product['name'] }}</p>
							<p class="h4 orange">₱ {{ number_format($product['member_price'], 2) }}</p>
							@if(isset($product['codes']))
								@foreach($product['codes'] as $code)
									<input type="hidden" name="product[{{ $product['id'] }}][name]" value="{{  $product['name'] }}">
									<input type="hidden" name="product[{{ $product['id'] }}][codes][value][]" value="{{ $code['code'] }}">
									<input type="hidden" name="product[{{ $product['id'] }}][codes][password][]" value="{{ $code['password'] }}">
									<p class="orange">CODE: {{ $code['code'] }}, PASSWORD: {{ $code['password'] }}</p>
								@endforeach
							@endif
						</div>
						<div class="col-sm-2">
							<input type="hidden" name="product[{{ $product['id'] }}][quantity]" value="{{ $product['quantity'] }}">
							<div class="h2 p-5">X {{ $product['quantity'] }}</div>
						</div>
					</div>
					<hr>
				@endforeach
				<div class="row text-center">
					<div class="col text-sm-left">
						<p></p>
					</div>
					<div class="col text-sm-right">
						<input type="hidden" name="total" value="{{ $totalPurchase }}">
						<p>Order Total: <strong class="h2 orange">₱ {{ number_format($totalPurchase, 2) }}</strong></p>
					</div>
				</div>
			</div>
		@endif
		<div class="col-12 my-4 text-center">
			<span class="h3">Payment Method</span>
		</div>
		<div class="col-12 bg-white my-3 p-3">
			<div class="row text-center">
				<div class="col text-sm-left pl-5">
					<strong>eWallet</strong>
				</div>
				<div class="col text-sm-right">
					<a href=""><i class="fas fa-fw fa-check fa-2x orange"></i></a>
				</div>
			</div>
		</div>
		<div class="col-12 my-4 text-center">
			<span class="h3">Pick-up Center</span>
		</div>
		<div class="col-12 bg-white my-3 p-3">
			<div class="row text-center">
				<div class="col pl-5">
					<div class="w-50 form-group pull-right">
						<select name="branch" class="w-100" required="">
							<option value="0" >Please select pick-up branch.</option>
							@foreach($branches as $key => $branch)
		                        <option value="{{ $key }}" >{{ $branch->name }}</option>
		                	@endforeach
		                </select>
		            </div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="row bg-white my-3 p-3">
				<div class="col">
					<div class="row pull-right">
						<button type="submit" class="col-sm-12 w-100 p-3 btn rounded-0 orange bg">Place order</button>
					</div>
				</div>
			</div>
		</div>
	</div>
{{ Form::close() }}
@stop
@section('plugin_js')
	<script>
		$(document).ready(function(){
			$('button[type=submit]').prop('disabled', true);

			$('[name=branch]').on('change', function(){
				if ($(this).val() !== '0') {
					$('button[type=submit]').prop('disabled', false);
				}
			})
		});
	</script>
@stop