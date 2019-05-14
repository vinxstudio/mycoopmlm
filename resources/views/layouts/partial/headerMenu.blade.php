<header id="header">

    <!-- Start header left -->
    <div class="header-left">
        <!-- Start offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
        <div class="navbar-minimize-mobile left">
            <i class="fa fa-bars"></i>
        </div>
        <!--/ End offcanvas left -->

        <!-- Start navbar header -->
        <div class="navbar-header" style="background-color: #FFFFFF; width: 400px;/*border: 1px solid #DDD;*/">

            <!-- Start brand -->
            <a id="tour-1" class="navbar-brand" href="{{ url(Request::segment(1).'/dashboard') }}">
                <img src="{{ asset('public/img/logo.png') }}">
            </a><!-- /.navbar-brand -->
            <!--/ End brand -->
            <div class="clearfix"></div>
        </div><!-- /.navbar-header -->
        <!--/ End navbar header -->

        <!-- Start offcanvas right: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
        <!--<div class="navbar-minimize-mobile right">
            <i class="fa fa-cog"></i>
        </div> -->
        <!--/ End offcanvas right -->

        <div class="clearfix"></div>
    </div><!-- /.header-left -->
    <!--/ End header left -->

    <!-- Start header right -->
    <div class="header-right">
        <!-- Start navbar toolbar -->
        <div class="navbar navbar-toolbar" style="flex-direction:row;display:block;padding:0px;">

            <!-- Start left navigation -->
            <ul class="nav navbar-nav navbar-left" style="flex-direction:row;">

                <!-- Start sidebar shrink -->
                <!-- <li id="tour-2" class="navbar-minimize">
                    <a href="javascript:void(0);" title="Minimize sidebar">
                        <i class="fa fa-bars"></i>
                    </a>
                </li> -->
                <!--/ End sidebar shrink -->

            </ul><!-- /.nav navbar-nav navbar-left -->
            <!--/ End left navigation -->

            <!-- Start right navigation -->
            <ul class="nav navbar-nav navbar-right" style="flex-direction:row;"><!-- /.nav navbar-nav navbar-right -->

                <!-- Start messages -->
                @if($theUser->role == 'member' && !empty($myaccounts))
                <li id="tour-4" class="header-dropdown-username">

                    {{ Form::open([
                            'class'=>'form-horizontal form-bordered',
                            'url' => 'member/dashboard/login', 
                            'method' => 'POST'
                            ]) }}
                    <label>USERNAME: </label>
                    <select name="goto_user_id" style="padding: 5px;">
                        <option value="0"> - Select Username - </option>

                        @foreach( $myaccounts as $myaccount )
                            @if($myaccount->role == 'member')
                                <option value="{{ $myaccount->id }}">{{ $myaccount->username }}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="submit" value="GO">
                    {{ Form::close() }}
                </li>
                @endif
                <!-- Start profile -->
                <li id="tour-4" class="dropdown navbar-profile">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="meta">
                                    <span class="avatar"><img src="{{ url($theUser->details->thePhoto) }}" class="img-circle" alt="admin" width="35" height="35"></span>
                                    <span class="text hidden-xs hidden-sm text-muted">{{ $theUser->details->first_name }}</span>
                                    <span class="caret"></span>
                                </span>
                    </a>
                    <!-- Start dropdown menu -->
                    <ul class="dropdown-menu animated flipInX">
                        <li class="dropdown-header">{{ Lang::get('labels.account') }}</li>
                        <li><a href="{{ url(Request::segment(1).'/profile') }}"><i class="fa fa-user"></i>{{ Lang::get('labels.view_profile') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i>

{{ Lang::get('labels.logout') }}</a></li>
                    </ul>
                    <!--/ End dropdown menu -->
                </li><!-- /.dropdown navbar-profile -->
                <!-- <li id="tour-4" class="dropdown">
                    <h5 style="line-height: 26px;">E-Funds: PHP. {{ (!empty($eWalletBalance))? number_format($eWalletBalance, 2):'0.00' }}</label>
                </li> -->
                <!--/ End profile -->

                <!-- Start settings -->
                <!-- <li id="tour-7" class="navbar-setting pull-right">
                    <a href="javascript:void(0);"><i class="fa fa-cog fa-spin"></i></a>
                </li> --><!-- /.navbar-setting pull-right -->
                <!--/ End settings -->

            </ul>
            <!--/ End right navigation -->

        </div><!-- /.navbar-toolbar -->
        <!--/ End navbar toolbar -->
    </div><!-- /.header-right -->
    <!--/ End header left -->

</header> <!-- /#header -->
<!--/ END HEADER -->
