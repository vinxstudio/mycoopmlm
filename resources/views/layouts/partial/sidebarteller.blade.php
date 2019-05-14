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
      
    
        <li class="submenu {{ ($segment2 == 'dashboard' or in_array($segment2, $menus['dashboard'])) ? 'active' : null }}">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">{{ Lang::get('labels.dashboard') }}</span>
                <span class="arrow"></span>
               
            </a>
            <ul>
                    <li {{ ($segment2 == ACTIVATION_CODES_MODULE) ? 'class="active"' : null }}><a href="{{ url('teller/activation-codes') }}">{{ Lang::get('labels.activation_codes') }}</a></li>
             
             </ul>
            </li>
  
    </ul>
</aside><!-- /#sidebar-left -->
<!--/ END SIDEBAR LEFT -->