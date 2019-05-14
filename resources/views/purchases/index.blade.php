@extends('layouts.members')
@section('plugin_css')
	<link rel="stylesheet" href="{{ asset('public/assets/member/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/member/custom/member_purchase.css') }}"/>
@stop
@section('content')
<div class="voucher-wrapper row p-3">
	<div class="col-12 col-sm-3">
		<div class="nav flex-column nav-tabs ml-5" role="tablist">
			<a class="nav-link @if(!$history) active @endif" href="#points" role="tab" data-toggle="tab" onClick"showTab('points')">
				<i class="fas fa-star fa-fw fa-lg align-middle fa-pull-left"></i> Unilevel Points
			</a>
			<a class="nav-link @if($history) active @endif" href="#purchase" role="tab" data-toggle="tab" onClick"showTab('purchase')">
				<i class="fas fa-shopping-cart fa-fw fa-lg align-middle fa-pull-left"></i> My Purchase
			</a>
			<a class="nav-link" href="#voucher" role="tab" data-toggle="tab" onClick"showTab('voucher')">
				<i class="fas fa-ticket-alt fa-fw fa-lg align-middle fa-pull-left"></i> My Voucher
			</a>
		</div>
	</div>
	<div class="col">
		<div class="tab-content">
			<div class="tab-pane @if(!$history) active @else fade @endif" id="points">
				<table class="table responsive unilevel">
					<thead>
						<tr>
							<th scope="col"> </th>
							<th scope="col">Product Name</th>
							<th scope="col">Product Quantity</th>
							<th scope="col">Product Amount</th>
							<th scope="col">Unilevel Points</th>
							<th scope="col">Date/Time Purchased</th>
							<th scope="col">Purchased User</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0; ?>
						@foreach($unilevels as $unilevel)
						<?php $i++; ?>
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $unilevel->type }}</td>
							<td>{{ $unilevel->quantity }}</td>
							<td> ₱ {{ number_format($unilevel->prod_amount,2) }}</td>
							<td> ₱ {{ number_format($unilevel->amount, 2) }}</td>
							<td>{{ date("M/d/Y", strtotime($unilevel->created_at)) }}</td>
							<td>{{ $unilevel->first_name.' '. $unilevel->last_name  }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="tab-pane @if($history) active @else fade @endif" id="purchase">
				<div class="pull-right w-40 m-2" id="purchase_history_select">
					<select class="form-control mt-0 pt-0">
						<option disabled selected value="0" class="hide">Status</option>
						<option value="0">All</option>
						<option @if($status == 4) selected @endif value="4">Pickup</option>
						<option @if($status == 5) selected @endif value="5">Complete / Received</option>
					</select>
				</div>

				<table class="table responsive purchase">
					<thead>
						<tr>
							<th scope="col"> </th>
							<th scope="col" class="w-13">Product Name</th>
							<th scope="col" class="w-8">Product Quantity</th>
							<th scope="col" class="w-10">Product Codes</th>
							<th scope="col" class="w-10">Member Price</th>
							<th scope="col" class="w-10">Product Price</th>
							<th scope="col" class="w-10">Product Total Price</th>
							<th scope="col" class="w-8">Unilevel Amount</th>
							<th scope="col" class="w-13">Date Purchased</th>
							<th scope="col" class="w-15">Status</th>
						</tr>
					</thead>
					<tbody>
						<!-- for laravel 5.2 => -->
						<!-- use @php and @endphp -->
						<?php
							$i = ($purchases->currentpage()-1)* $purchases->perpage() + 1; 
							$product_total = 0;
						?>
						@foreach ($purchases as $purchase)
							<tr>
								<td>
									<div class="pt-2">
										{{ $i++ }}
									</div>
								</td>
								<!-- products name -->
								<td>
									@foreach ($purchase->purchase_products as $product)
										<table class="table table-no-border">
											<tr>
												<td>
													{{ $product->product->name }}
												</td>
											</tr>
										</table>
									@endforeach	
								</td>
								<!-- quantity -->
								<td>
									@foreach ($purchase->purchase_products as $product)
										<table class="table table-no-border">
											<tr>
												<td>
													{{ $product->quantity }}
												</td>
											</tr>
										</table>
									@endforeach
								</td>
								{{-- show product codes --}}
								<td>
									@foreach ($purchase->purchase_products as $product)
										<table class="table table-no-border fixed">
											<tr>
												<td>
													{{-- dropdown for showing product codes and password --}}
													<div class="dropdown w-100">
														<button class="btn btn-secondary w-100 text-center" type="button" id="codes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															{{-- header --}}
															<span class="cut-text">
																{{ $product->product->name }} Codes
															</span>
														</button>
														<div class="bg-white dropdown-menu" aria-labelledby="codes">
															@foreach ($product->purchase_product_codes as $code)
																{{-- product code --}}
																<div class="w-100 m-2 pr-3 text-dark">
																	<span class="badge badge-light font-weight-bold">
																		Code
																		@if($code->status == 3)
																			<kbd style="background-color: maroon">
																				Activated
																			</kbd>
																		@elseif($code->status == 1)
																			<kbd style="background-color: #0F1D24">
																				Not Activated
																			</kbd>
																		@endif
																	</span>
																	<span class="m-2 font-weight-bold d-block">
																		{{ $code->product_code }}
																	</span>
																</div>
																{{-- product password --}}
																<div class="w-100 m-2 pr-3 text-dark">
																	<span class="badge badge-light font-weight-bold">
																		Password
																	</span>
																	<span class="m-2 font-weight-bold d-block">
																		{{ $code->password }}
																	</span>
																</div>
																{{-- get last item of codes --}}
																<?php 
																	$code_first_end = end($product->purchase_product_codes);
																	$code_second_end = end($code_first_end);
																?>
																@if($code_second_end->product_code != $code->product_code)
																	<hr class="hr-code" />
																@endif
															@endforeach
														</div>
													</div>
												</td>
											</tr>
										</table>
									@endforeach	
								</td>
								<!-- member price -->
								<td>
									@foreach ($purchase->purchase_products as $product)
										<table class="table table-no-border">
											<tr>
												<td>
													₱ 
													<span class="font-weight-bold">
														{{ number_format($product->rebates, 2) }}
													</span>
												</td>
											</tr>
										</table>
									@endforeach
								</td>
								<!-- amount of product -->
								<td>
									@foreach ($purchase->purchase_products as $product)
										<!-- laravel 5.2 => use @php and @endphp -->
										<?php
											$product_total += $product->amount * $product->quantity;
										?>
										<table class="table table-no-border">
											<tr>
												<td>
													₱ 
													<span class="font-weight-bold">
														{{ number_format($product->amount, 2) }}
													</span>
												</td>
											</tr>
										</table>
									@endforeach
								</td>
								<!-- product total price -->
								<td cellpadding="2">
									<div class="pt-2">
										₱ 
										<span class="font-weight-bold">
											{{ number_format($product_total, 2) }}
										</span>
									</div>

									<!-- laravel 5.2 > use @php and @endphp -->
									<?php 
										$product_total = 0;
									?>
								</td>
								<!-- unilevel amount -->
								<td>
									@foreach ($purchase->purchase_products as $product)
										<!-- laravel 5.2 => use @php and @endphp -->
										<table class="table table-no-border">
											<tr>
												<td>
													<?php
														$toId = $product->product_id . 555;
														$toArr = $unilevel_amount->where('product_id', (int)$toId)->toArray();
														$toRes = reset($toArr);
														$toAmm = $toRes['amount'];
													?>
													₱ {{ $toAmm }}
												</td>
											</tr>
										</table>
	
									@endforeach
								</td>
								<td>
									<div class="pt-2">
										{{ date("M/d/Y", strtotime($purchase->created_at)) }}
									</div>
								</td>
								<td>
									<div class="pt-2">
										{{ $purchase->status_string }} at 	
										<br>
										{{ $purchase->branch->name }}
									</div>
								</td>
							</tr>
						@endforeach
					</table>
				</tbody>

				{{ $purchases->appends(['history' => 'true'])->render() }}

				{{-- <div class="row">
					<div class="col-12">
						<div class="row text-center">
							<div class="col">
								<a class="text-dark" href="{{ URL::to('member/purchases/list/') }}">
									All<br>
									<span class="orange bg rounded-circle my-3 p-5 fa-layers fa-2x fa-inverse">
										<i class="fas fa-bars" data-fa-transform=""></i>
									</span>
								</a>
							</div>
							<div class="col">
								<a class="text-dark" href="{{ URL::to('member/purchases/list/?status=4') }}">
									Pick up<br>
									<span class="orange bg rounded-circle my-3 p-5 fa-layers fa-2x fa-inverse">
										<i class="fas fa-truck" data-fa-transform=""></i>
									</span>
								</a>
							</div>
							<div class="col">
								<a class="text-dark" href="{{ URL::to('member/purchases/list/?status=5') }}">
									Completed/Received<br>
									<span class="orange bg rounded-circle my-3 p-5 fa-layers fa-2x fa-inverse">
										<i class="fas fa-check" data-fa-transform=""></i>
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				@foreach($purchases as $purchase)
					<div class="prod-purchase row py-3 border m-3">
						<div class="col-6">
							<div class="date">{{ date("M/d/Y", strtotime($purchase->created_at)) }}</div>
						</div>
						<div class="col-6 text-right">
							<div class="meta">
								<ul class="list-inline m-0">
									<li class="list-inline-item align-middle">
										<a class="text-dark" href="">
											{{ $purchase->status_string }} at {{ $purchase->branch->name }}
										</a>
									</li>
								</ul>
							</div>
						</div>
						<hr class="w-100"></hr>
						@foreach($purchase->purchaseProducts as $purchaseProduct)
							<div class="col-8">
								<img class="bg-grey float-left mr-3" src="assets/img/prod.png" alt="">
								<p class="h3">{{ $purchaseProduct->product->name }}</p>
								<p class="h5">Qty: {{ $purchaseProduct->quantity }}</p>
							</div>
							<div class="col-4 align-self-end text-center">
								<p class="h4 orange mb-3">
									Member's Price: ₱ {{ number_format($purchaseProduct->rebates, 2) }}
								</p>
								<p class="h4 orange mb-3">
									SRP: ₱ {{ number_format($purchaseProduct->amount, 2) }}
								</p>
							</div>
						@endforeach
					</div>
				@endforeach
				<div class="col-8">
					{{ $purchases->render() }}
				</div> --}}
			</div>
			<div class="tab-pane fade" id="voucher">
				<table class="table responsive voucher">
					<thead>
						<tr>
							<th scope="col"> </th>
							<th scope="col">Date Created</th>
							<th scope="col">Code</th>
							<th scope="col">Date Time Used</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row"><img src="assets/img/vouch.png" alt=""></th>
							<td>- - -</td>
							<td><a href="">CPMPC 0321 5640 3156</a></td>
							<td>- - -</td>
						</tr>
						<tr>
							<th scope="row"><img src="assets/img/vouch.png" alt=""></th>
							<td>- - -</td>
							<td>
								<button class="btn w-100 rounded-0 orange bg" type="button">USE</button>
								<br>
								TO GENERATE CODE
							</td>
							<td>- - -</td>
						</tr>
						<tr>
							<th scope="row"><img src="assets/img/vouch.png" alt=""></th>
							<td>- - -</td>
							<td>
								<button class="btn w-100 rounded-0 orange bg" type="button">USE</button>
								<br>
								TO GENERATE CODE
							</td>
							<td>- - -</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>

	var purchase = '#purchase';


	var history_purchase = '';
	var history_status = '';

	var unilevel = '';

	var page = '';
	
	$(document).ready(function(){

		history_purchase = getParameterByName('history');
		history_status = getParameterByName('status');

		page = getParameterByName('page');

		$('.nav-link').click(function(e){

			var nav_all = $('.nav-link');
			var nav = $(this);

			nav_all.removeClass('active');
			nav.addClass('active');

		});

		// $('.nav-link').click(function(){

		// 	let href_data = $(this).attr('href');

		// 	if(href_data != purchase){
		// 		window.history.replaceState(null, null, window.location.pathname);
		// 	}
		// 	else if(href_data == purchase){
				
		// 		let parameter = '';

		// 		if(history_status != null)
		// 			parameter += "status=" +history_status;
		// 		if(history_purchase != null)
		// 			parameter += "history=" + history_purchase;
		// 		if(page != null)
		// 			parameter += "page=" + page;  
				
		// 		window.history.replaceState(null, null, window.location.pathname + "?" + parameter);
		// 	}
		// });

		$('#purchase_history_select').change(function(e){

			if(e.target.value == 0){
				window.location.href = window.location.pathname + "?history=true";
			}
			else{
				window.location.href = window.location.pathname + "?status=" + e.target.value + "&history=true"; 
			}
			
		});

		$('.dropdown .dropdown-menu').click(function(e){
			e.stopPropagation();
		})

	});


	function getParameterByName(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
 	}

</script>

@stop