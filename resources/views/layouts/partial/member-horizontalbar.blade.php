<div id="tour-11 col-md-12 row" class="header-content text-center">
	<div style="text-align: center" class="col-sm-12">
		<div class="h-menu col-centered" style="">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-tachometer-alt fa-3x"></i>
				<div>Dashboard</div>
			</a>
			<ul class="h-sub-menu dropdown-menu animated flipInX">
                <li {{ ($segment2 == 'dashboard') ? 'class="active"' : null }}><a href="{{ url('member/dashboard') }}">{{ Lang::get('labels.summary') }}</a></li>
                <li {{ ($segment2 == 'investment') ? 'class="active"' : null }}><a href="{{ url('member/investments') }}">{{ Lang::get('labels.transaction_logs') }}</a></li>
				<li {{ ($segment2 == 'payout-history') ? 'class="active"' : null }}><a href="{{ url('member/payout-history') }}">Income History</a></li>
				<li {{ ($segment3 == 'history') ? 'class="active"' : null }}><a href="{{ url('member/giftcheck/history') }}">Giftcheck History</a></li>
				<li {{ ($segment2 == 'weeklypayout') ? 'class="active"' : null }}><a href="{{ url('member/weeklypayout') }}">Weekly Payout History</a></li>
				<li {{ ($segment2 == 'summary') ? 'class="active"' : null }}><a href="{{ url('member/summary') }}">Income/Encashment Summary</a></li>
            </ul>
		</div>
		<div class="h-menu col-centered">
			<a href="{{ url('member/network-tree') }}" class="" data-toggle="">
				<i class="fas fa-users fa-3x"></i>
				<div>{{ Lang::get('labels.network_tree') }}</div>
			</a>
		</div>
		<?php $production = true;  ?>
		@if($production)
		<div class="h-menu col-centered">
			<a href="{{ url('member/programServices/') }}" class="" data-toggle="">
				<i class="fas fa-shopping-bag fa-3x"></i>
				<div>{{ Lang::get('labels.programServices') }}</div>
			</a>
		</div>
		<div class="h-menu col-centered">
			<a href="{{ url('member/transactions/') }}" class="" data-toggle="">
				<i class="fas fa-file-alt fa-3x"></i>
				<div>{{ Lang::get('labels.transactions') }}</div>
			</a>
		</div>
		@endif
	   	<div class="h-menu col-centered">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-shopping-cart fa-3x"></i>
                <div>Purchases</div>
            </a>
            <ul class="h-sub-menu dropdown-menu animated flipInX">
                <li {{ ($segment3 == 'buy') ? 'class="active"' : null }}><a href="{{ url('member/programServices/eCommerce') }}">{{ Lang::get('labels.buy_product') }}</a></li>
                <li {{ ($segment3 == 'encode') ? 'class="active"' : null }}><a href="{{ url('member/purchases/encode') }}">{{ Lang::get('labels.encode') }}</a></li>
				{{-- January 13, 2019 --}}
				{{-- remove encode product code in member --}}
				{{-- <li {{ ($segment3 == 'encode-product-codes') ? 'class="active"' : null }}><a href="{{ url('member/purchases/encode-product-codes') }}">Encode Product Codes</a></li> --}}
                <li {{ ($segment3 == 'list') ? 'class="active"' : null }}><a href="{{ url('member/purchases/list') }}">{{ Lang::get('labels.purchase_history') }}</a></li>
			</ul>
		</div>
		<div class="h-menu  col-centered">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="far fa-credit-card fa-3x"></i>
				<div>Withdrawals</div>
            </a>
            <ul class="h-sub-menu dropdown-menu animated flipInX">
                <li {{ ($segment3 == 'request') ? 'class="active"' : null }}><a href="{{ url('member/withdrawals/request') }}">{{ Lang::get('labels.request_withdrawal') }}</a></li>
                <li {{ ($segment3 == 'pending') ? 'class="active"' : null }}><a href="{{ url('member/withdrawals/pending') }}">{{ Lang::get('labels.pending_withdrawal') }}</a></li>
                <li {{ ($segment3 == 'history') ? 'class="active"' : null }}><a href="{{ url('member/withdrawals/history') }}">{{ Lang::get('labels.history_withdrawal') }}</a></li>
            </ul>
			
		</div>
		<div class="h-menu col-centered">
			<a href="https://support.mycoop.ph/" class="" data-toggle="">
				<i class="fas fa-headphones fa-3x"></i>
				<div>Support</div>
			</a>
		</div>
		<!-- <div class="h-menu col-centered">
			<mycoop-bot page_id="662341780776325" uid="CPMPCMAINOFFICE001"></mycoop-bot>
			<script src="https://goo.gl/zuEhQk"></script>
		</div> -->
		<div class="h-menu pull-right">
			<a href="javascript:void(0)" >
				<div>E-Funds</div>
				<label style="background-color: #fff; color: #000; padding:5px;"> PHP. {{ (!empty($eWalletBalance) && $eWalletBalance > 0)? number_format($eWalletBalance, 2):'0.00' }} </label>
			</a>
		</div>
	</div>
</div>