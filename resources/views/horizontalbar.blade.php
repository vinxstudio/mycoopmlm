<div id="tour-11 col-md-12 row" class="header-content text-center">

	<div style="width: 800px;margin: 0 auto;">
		@if (hasAccess(DASHBOARD_MODULE)
	        or hasAccess(ACTIVATION_CODES_MODULE)
	        or hasAccess(MEMBERS_MODULE)
	        or hasAccess(FUNDING_MODULE)
	        or hasAccess(TRANSACTIONS_MODULE)
	        or hasAccess(WITHDRAWALS_MODULE)
	        or hasAccess(TOP_EARNERS_MODULE)
	        or hasAccess(ADMINISTRATORS_MODULE))
		<div class="h-menu col-centered" style="float: left; width: 150px; position: relative;">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-tachometer-alt fa-3x"></i>
				<div>{{ Lang::get('labels.dashboard') }}</div>
			</a>
			<ul class="h-sub-menu dropdown-menu animated flipInX">
                @if (hasAccess(DASHBOARD_MODULE))
                    <li {{ ($segment2 == DASHBOARD_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/dashboard') }}">{{ Lang::get('labels.summary') }}</a></li>
                @endif

                @if (hasAccess(ACTIVATION_CODES_MODULE))
                    <li {{ ($segment2 == ACTIVATION_CODES_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/activation-codes') }}">{{ Lang::get('labels.activation_codes') }}</a></li>
                @endif
                @if (hasAccess(MEMBERS_MODULE))
                    <li {{ ($segment2 == MEMBERS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/members') }}">{{ Lang::get('labels.members') }}</a></li>
                @endif
                @if (hasAccess(FUNDING_MODULE))
                    <li {{ ($segment2 == FUNDING_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/funding') }}">{{ Lang::get('labels.funding') }}</a></li>
                @endif
                @if (hasAccess(TRANSACTIONS_MODULE))
                    <li {{ ($segment2 == TRANSACTIONS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/transactions') }}">{{ Lang::get('labels.transaction_history') }}</a></li>
                @endif
                @if (hasAccess(WITHDRAWALS_MODULE))
                    <li {{ ($segment2 == WITHDRAWALS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/withdrawals') }}">{{ Lang::get('labels.withdrawals') }}</a></li>
                @endif
                @if (hasAccess(TOP_EARNERS_MODULE))
                    <li {{ ($segment2 == TOP_EARNERS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/top-earners') }}">{{ Lang::get('labels.top_earners') }}</a></li>
                @endif
                @if (hasAccess(ADMINISTRATORS_MODULE))
                    <li {{ ($segment2 == ADMINISTRATORS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/administrators') }}">{{ Lang::get('labels.administrators') }}</a></li>
                @endif
                @if (hasAccess(PAYMENT_HISTORY_MODULE))
                    <li {{ ($segment2 == PAYMENT_HISTORY_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/payment-history') }}">{{ Lang::get('labels.payment_history') }}</a></li>
					<li {{ ($segment2 == REGISTRATON_HISTORY_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/registration-history') }}">Registration History</a></li>
                    <li {{ (($segment3 != PAYOUT_HISTORY_DR_MODULE || $segment3 != PAYOUT_HISTORY_MB_MODULE) && $segment2 == PAYOUT_HISTORY_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/payout-history') }}">Payout History</a></li>

                    <li {{ ($segment3 == PAYOUT_HISTORY_DR_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/payout-history/directreferral') }}">Payout History Direct Referral</a></li>
					<li {{ ($segment3 == PAYOUT_HISTORY_MB_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/payout-history/matchingbonus') }}">Payout History Matching Bonus</a></li>
				@endif
            </ul>
		</div>
		@endif
		@if (hasAccess(PRODUCTS_MODULE) or hasAccess(PURCHASE_CODES_MODULE) or hasAccess(UNILEVEL_MODULE))
	   	<div class="h-menu col-centered" style="float: left; width: 150px;  position: relative;">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-tags fa-3x"></i>
                <div>{{ Lang::get('labels.products') }}</div>
            </a>
            <ul class="h-sub-menu dropdown-menu animated flipInX">
                @if (hasAccess(PRODUCTS_MODULE))
                    <li {{ ($segment2 == PRODUCTS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/products') }}">{{ Lang::get('labels.product_list') }}</a></li>
                @endif
                @if (hasAccess(PURCHASE_CODES_MODULE))
                    <li {{ ($segment3 == PURCHASE_CODES_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/products/purchase-codes') }}">{{ Lang::get('labels.purchase_codes') }}</a></li>
                @endif
                @if (hasAccess(UNILEVEL_MODULE))
                    <li {{ ($segment3 == UNILEVEL_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/products/unilevel') }}">{{ Lang::get('labels.unilevel_settings') }}</a></li>
                @endif
            </ul>
		</div>
		@endif
		@if (hasAccess(COMPANY_DETAILS_MODULE) or hasAccess(CONNECTIONS_MODULE) or hasAccess(CODE_SETTINGS_MODULE))
		<div class="h-menu  col-centered" style="float: left; width: 150px;  position: relative;">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-university fa-3x"></i>
				<div>{{ Lang::get('labels.company') }}</div>
            </a>
            <ul class="h-sub-menu dropdown-menu animated flipInX">
                @if (hasAccess(COMPANY_DETAILS_MODULE))
                    <li {{ ($segment2 == COMPANY_DETAILS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/company') }}">{{ Lang::get('labels.company_details') }}</a></li>
                @endif
                @if (hasAccess(CONNECTIONS_MODULE))
                    <li {{ ($segment2 == CONNECTIONS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/connections') }}">{{ Lang::get('labels.connections') }}</a></li>
                @endif
                @if (hasAccess(CODE_SETTINGS_MODULE))
                    <li {{ ($segment2 == 'settings') ? 'class="active"' : null }}><a href="{{ url('admin/settings') }}">{{ Lang::get('labels.settings') }}</a></li>
                @endif
                @if (hasAccess(PAYPAL_MODULE))
                    <li {{ ($segment3 == PAYPAL_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/paypal/settings') }}">{{ Lang::get('labels.paypal_settings') }}</a></li>
                @endif
            </ul>
			
		</div>
		@endif
		@if (hasAccess(COMPENSATION_INCOME_MODULE) or hasAccess(PAIRING_MODULE) or hasAccess(WITHDRAWAL_SETTINGS_MODULE))
		<div class="h-menu  col-centered" style="float: left; width: 150px;  position: relative;">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-university fa-3x"></i>
				<div>{{ Lang::get('labels.income_payout') }}</div>
            </a>
            <ul class="h-sub-menu dropdown-menu animated flipInX">
                @if (hasAccess(COMPENSATION_INCOME_MODULE))
                    <li {{ ($segment2 == COMPENSATION_INCOME_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/income') }}">{{ Lang::get('labels.income_settings') }}</a></li>
                @endif
                @if (hasAccess(PAIRING_MODULE))
                    <li {{ ($segment2 == PAIRING_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/pairing') }}">{{ Lang::get('labels.pairing_settings') }}</a></li>
                @endif
                @if (hasAccess(WITHDRAWAL_SETTINGS_MODULE))
                    <li {{ ($segment2 == WITHDRAWAL_SETTINGS_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/withdrawal-settings') }}">{{ Lang::get('labels.withdrawal_settings') }}</a></li>
                @endif
            </ul>
			
		</div>
		@endif
		@if (hasAccess(MAIL_TEMPLATES_MODULE))
		<div class="h-menu  col-centered" style="float: left; width: 150px;  position: relative;">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-envelope fa-3x"></i>
				<div>{{ Lang::get('labels.mailing') }}</div>
            </a>
            <ul class="h-sub-menu dropdown-menu animated flipInX">
                 <li {{ ($segment2 == MAIL_TEMPLATES_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/mail-templates') }}">{{ Lang::get('labels.mail_templates') }}</a></li>
            </ul>
			
		</div>
		@endif
	</div>
</div>
