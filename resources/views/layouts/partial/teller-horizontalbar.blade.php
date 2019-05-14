<div id="tour-11 col-md-12 row" class="header-content text-center">
	<div style="text-align: center">
		<div class="h-menu col-centered" style="">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-tachometer-alt fa-3x"></i>
				<div>Dashboard</div>
			</a>
			<ul class="h-sub-menu dropdown-menu animated flipInX">
                <li {{ ($segment2 == ACTIVATION_CODES_MODULE) ? 'class="active"' : null }}><a href="{{ url('teller/activation-codes') }}">{{ Lang::get('labels.activation_codes') }}</a></li>
            </ul>
            
		</div>
		<div class="h-menu col-centered" style="">
			<a href="/teller/activation-codes/view-activation-code">
				<i class="fas fa-clipboard-list  fa-3x"></i>
				<div>Generated Codes</div>
			</a>
		</div>
		<div class="h-menu col-centered" style="">
			<a href="{{ url('teller/members') }}">
					<i class="fas fa-users fa-3x"></i>
				<div>{{ Lang::get('labels.members') }}</div>
			</a>
		</div>
		<div class="h-menu col-centered" style="">
			<a href="/teller/activation-codes/for-maintenance">
				<i class="far fa-list-alt fa-3x"></i>
				<div>For Maintenance</div>
			</a>
		</div>
		<div class="h-menu col-centered" style="">
			<a href="/teller/product-codes">
				<i class="far fa-list-alt fa-3x"></i>
				<div>Products</div>
			</a>
		</div>
	</div>
</div>
