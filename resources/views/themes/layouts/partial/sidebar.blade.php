<aside id="sidebar-left" class="sidebar-circle">

    <!-- Start left navigation - profile shortcut -->
    <div id="tour-8" class="sidebar-content">
        <div class="media">
            <a class="pull-left has-notif avatar" href="#">
                <img src="{{ url($theUser->details->thePhoto); }}" alt="admin">
                <i class="online"></i>
            </a>
            <div class="media-body">
                <h4 class="media-heading">Hello, <span>{{ $theUser->details->first_name }}</span></h4>
                <small>Welcome to your success</small>
            </div>
        </div>
    </div><!-- /.sidebar-content -->
    <!--/ End left navigation -  profile shortcut -->

    <!-- Start left navigation - menu -->
    <ul id="tour-9" class="sidebar-menu">
        @if (hasAccess(DASHBOARD_MODULE)
        or hasAccess(ACTIVATION_CODES_MODULE)
        or hasAccess(MEMBERS_MODULE)
        or hasAccess(FUNDING_MODULE)
        or hasAccess(TRANSACTIONS_MODULE)
        or hasAccess(WITHDRAWALS_MODULE)
        or hasAccess(TOP_EARNERS_MODULE)
        or hasAccess(ADMINISTRATORS_MODULE))
		
    
        <li class="submenu {{ ($segment2 == 'dashboard' or in_array($segment2, $menus['dashboard'])) ? 'active' : null }}">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">{{ Lang::get('labels.dashboard') }}</span>
                <span class="arrow"></span>
                @if ($segment2 == 'dashboard' or in_array($segment2, $menus['dashboard']))
                    <span class="selected"></span>
                @endif
            </a>
            <ul>
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
					<li {{ ($segment2 == PAYOUT_HISTORY_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/payout-history') }}">Payout History</a></li>
				@endif
            </ul>
        </li>
        @endif
        @if (hasAccess(PRODUCTS_MODULE) or hasAccess(PURCHASE_CODES_MODULE) or hasAccess(UNILEVEL_MODULE))
            <li class="submenu {{ ($segment2 == 'products' or in_array($segment2, $menus['products'])) ? 'active' : null }}">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-tags"></i></span>
                    <span class="text">{{ Lang::get('labels.products') }}</span>
                    <span class="arrow"></span>
                    @if ($segment2 == 'products' or in_array($segment2, $menus['products']))
                        <span class="selected"></span>
                    @endif
                </a>
                <ul>
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
            </li>
        @endif
        @if (hasAccess(COMPANY_DETAILS_MODULE) or hasAccess(CONNECTIONS_MODULE) or hasAccess(CODE_SETTINGS_MODULE))
            <!-- <li class="sidebar-category">
                <span>{{ Lang::get('labels.company_settings') }}</span>
                <span class="pull-right"><i class="fa fa-trophy"></i></span>
            </li> -->
            <li class="submenu {{ ($segment2 == 'company' or in_array($segment2, $menus['company'])) ? 'active' : null }}">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-bank"></i></span>
                    <span class="text">{{ Lang::get('labels.company') }}</span>
                    <span class="arrow"></span>
                    @if ($segment2 == 'company' or in_array($segment2, $menus['company']))
                        <span class="selected"></span>
                    @endif
                </a>
                <ul>
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
            </li>
        @endif

        @if (hasAccess(COMPENSATION_INCOME_MODULE) or hasAccess(PAIRING_MODULE) or hasAccess(WITHDRAWAL_SETTINGS_MODULE))
            <!-- <li class="sidebar-category">
                <span>{{ Lang::get('labels.compensation_settings') }}</span>
                <span class="pull-right"><i class="fa fa-trophy"></i></span>
            </li> -->
            <li class="submenu {{ ($segment2 == 'compensation-settings' or in_array($segment2, $menus['compensation-settings'])) ? 'active' : null }}">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-bank"></i></span>
                    <span class="text">{{ Lang::get('labels.income_payout') }}</span>
                    <span class="arrow"></span>
                    @if ($segment2 == 'compensation-settings' or in_array($segment2, $menus['compensation-settings']))
                        <span class="selected"></span>
                    @endif
                </a>
                <ul>
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
            </li>
        @endif
        @if (hasAccess(MAIL_TEMPLATES_MODULE))
            <!-- <li class="sidebar-category">
                <span>{{ Lang::get('labels.mail_settings') }}</span>
                <span class="pull-right"><i class="fa fa-envelope"></i></span>
            </li> -->
            <li class="submenu {{ ($segment2 == 'mail-settings' or in_array($segment2, $menus['mail-settings'])) ? 'active' : null }}">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-envelope"></i></span>
                    <span class="text">{{ Lang::get('labels.mailing') }}</span>
                    <span class="arrow"></span>
                    @if ($segment2 == 'mail-settings' or in_array($segment2, $menus['mail-settings']))
                        <span class="selected"></span>
                    @endif
                </a>
                <ul>
                    <li {{ ($segment2 == MAIL_TEMPLATES_MODULE) ? 'class="active"' : null }}><a href="{{ url('admin/mail-templates') }}">{{ Lang::get('labels.mail_templates') }}</a></li>
                </ul>
            </li>
        @endif
    </ul>
</aside><!-- /#sidebar-left -->
<!--/ END SIDEBAR LEFT -->