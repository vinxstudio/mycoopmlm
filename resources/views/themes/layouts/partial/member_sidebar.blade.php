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
                <small>Member</small><br/>
				<small>{{ $member->membership_type_name }}</small>
            </div>
        </div>
    </div><!-- /.sidebar-content -->
    <!--/ End left navigation -  profile shortcut -->

    <!-- Start left navigation - menu -->
    <ul id="tour-9" class="sidebar-menu">

        <!-- Start navigation - dashboard -->
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
                <li {{ ($segment2 == 'dashboard') ? 'class="active"' : null }}><a href="{{ url('member/dashboard') }}">{{ Lang::get('labels.summary') }}</a></li>
                <li {{ ($segment2 == 'investment') ? 'class="active"' : null }}><a href="{{ url('member/investments') }}">{{ Lang::get('labels.transaction_logs') }}</a></li>
                <li {{ ($segment2 == 'network-tree') ? 'class="active"' : null }}><a href="{{ url('member/network-tree') }}">{{ Lang::get('labels.network_tree') }}</a></li>
                <li {{ ($segment2 == 'payout-history') ? 'class="active"' : null }}><a href="{{ url('member/payout-history') }}">Payout History</a></li>
            </ul>
        </li>
        <li class="submenu {{ ($segment2 == 'purchases' or in_array($segment2, $menus['purchases'])) ? 'active' : null }}">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-tags"></i></span>
                <span class="text">{{ Lang::get('labels.purchases') }}</span>
                <span class="arrow"></span>
                @if ($segment2 == 'purchases' or in_array($segment2, $menus['purchases']))
                    <span class="selected"></span>
                @endif
            </a>
            <ul>
                <li {{ ($segment3 == 'buy') ? 'class="active"' : null }}><a href="{{ url('member/purchases/buy') }}">{{ Lang::get('labels.buy_product') }}</a></li>
                <li {{ ($segment3 == 'encode') ? 'class="active"' : null }}><a href="{{ url('member/purchases/encode') }}">{{ Lang::get('labels.encode') }}</a></li>
                <li {{ ($segment3 == 'history') ? 'class="active"' : null }}><a href="{{ url('member/purchases/history') }}">{{ Lang::get('labels.purchase_history') }}</a></li>
            </ul>
        </li>
        @if (config('system.enable_withdrawals'))
            <!-- <li class="sidebar-category">
                <span>{{ Lang::get('labels.withdrawals') }}</span>
                <span class="pull-right"><i class="fa fa-money"></i></span>
            </li> -->
            <li class="submenu {{ ($segment2 == 'withdrawals' or in_array($segment2, $menus['withdrawals'])) ? 'active' : null }}">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-bank"></i></span>
                    <span class="text">{{ Lang::get('labels.withdrawals') }}</span>
                    <span class="arrow"></span>
                    @if ($segment2 == 'withdrawal' or in_array($segment2, $menus['withdrawals']))
                        <span class="selected"></span>
                    @endif
                </a>
                <ul>
                    <li {{ ($segment3 == 'request') ? 'class="active"' : null }}><a href="{{ url('member/withdrawals/request') }}">{{ Lang::get('labels.request_withdrawal') }}</a></li>
                    <li {{ ($segment3 == 'pending') ? 'class="active"' : null }}><a href="{{ url('member/withdrawals/pending') }}">{{ Lang::get('labels.pending_withdrawal') }}</a></li>
                    <li {{ ($segment3 == 'history') ? 'class="active"' : null }}><a href="{{ url('member/withdrawals/history') }}">{{ Lang::get('labels.history_withdrawal') }}</a></li>
                </ul>
            </li>
        @endif
        <li><a href="javacript:void(0);">
                    <span class="icon"><i class="fa fa-pencil"></i></span>
                    <span>Update Membership</span>
                    <span class="arrow"></span>
                </a>
    </ul>
</aside><!-- /#sidebar-left -->
<!--/ END SIDEBAR LEFT -->