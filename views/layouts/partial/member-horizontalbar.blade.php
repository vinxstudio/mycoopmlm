<div id="tour-11 col-md-12 row" class="header-content text-center">
	<div style="text-align: center">
		<div class="h-menu col-centered" style="">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-tachometer-alt fa-3x"></i>
				<div>Dashboard</div>
			</a>
			<ul class="h-sub-menu dropdown-menu animated flipInX">
                <li {{ ($segment2 == 'dashboard') ? 'class="active"' : null }}><a href="{{ url('member/dashboard') }}">{{ Lang::get('labels.summary') }}</a></li>
                <li {{ ($segment2 == 'investment') ? 'class="active"' : null }}><a href="{{ url('member/investments') }}">{{ Lang::get('labels.transaction_logs') }}</a></li>
				<li {{ ($segment2 == 'payout-history') ? 'class="active"' : null }}><a href="{{ url('member/payout-history') }}">Payout History</a></li>
            </ul>
		</div>
		<div class="h-menu col-centered">
			<a href="{{ url('member/network-tree') }}" class="" data-toggle="">
				<i class="fas fa-users fa-3x"></i>
				<div>{{ Lang::get('labels.network_tree') }}</div>
			</a>
		</div>
		<div class="h-menu col-centered">
			<a href="{{ url('member/programServices/') }}" class="" data-toggle="">
				<i class="fas fa-shopping-bag fa-3x"></i>
				<div>{{ Lang::get('labels.programServices') }}</div>
			</a>
		</div>
		<div class="h-menu col-centered">
			<a href="{{ url('member/transactions/') }}" class="" data-toggle="">
				<i class="fas fa-shopping-cart fa-3x"></i>
				<div>{{ Lang::get('labels.transactions') }}</div>
			</a>
		</div>
	   	<div class="h-menu col-centered">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-shopping-cart fa-3x"></i>
                <div>Purchases</div>
            </a>
            <ul class="h-sub-menu dropdown-menu animated flipInX">
                <li {{ ($segment3 == 'buy') ? 'class="active"' : null }}><a href="{{ url('member/purchases/buy') }}">{{ Lang::get('labels.buy_product') }}</a></li>
                <li {{ ($segment3 == 'encode') ? 'class="active"' : null }}><a href="{{ url('member/purchases/encode') }}">{{ Lang::get('labels.encode') }}</a></li>
                <li {{ ($segment3 == 'history') ? 'class="active"' : null }}><a href="{{ url('member/purchases/history') }}">{{ Lang::get('labels.purchase_history') }}</a></li>
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
		<!-- <div class="h-menu col-centered" style="float: left; width: 150px; position: relative;">
			<a href="{{ url('member/profile') }}" class="" data-toggle="">
				<i class="fab fa-wpforms fa-3x"></i>
				<div>Update Membership</div>
			</a>
		</div> -->
	</div>
</div>
