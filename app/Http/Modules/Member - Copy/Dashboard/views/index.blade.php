@extends('layouts.members')
@section('content')
    <div id="tour-12" class="row" style="margin-top: 25px;">
        @if ($theUser->is_maintained == false)
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mini-stat clearfix bg-googleplus rounded"> 
                    <span class="mini-stat-icon"><i class="fa fa-lock fg-googleplus"></i></span>
                    <div class="mini-stat-info">
                        <span class="counter"><a href="{{ url('member/investments/buy') }}">{{ Lang::get('labels.activate_account') }}</a></span>
                        {{ Lang::get('labels.activation_reason') }}
                    </div>
                </div>
            </div>
        @endif
        <div class="mini-stat-wrap" style="margin-bottom: 25px; border-bottom: 1px solid #ddd;">
            <div class="row" style="margin-bottom: 50px;">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <div class="mini-stat clearfix bg-googleplus rounded">-->
                        <span class="mini-stat-icon"><i class="fa fa-money fg-googleplus"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->remainingBalance, 2) }}</span>
                            {{ Lang::get('labels.remaining_balance') }}
                        </div>
                    <!-- </div> -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <div class="mini-stat clearfix bg-facebook rounded">-->
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->earnings, 2) }}</span>
                            {{ Lang::get('labels.total_income') }}
                        </div>
                    <!-- </div> -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <div class="mini-stat clearfix bg-facebook rounded"> -->
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->rebatesIncome, 2) }}</span>
                            {{ Lang::get('labels.rebates_income') }}
                        </div>
                    <!-- </div> -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <div class="mini-stat clearfix bg-facebook rounded"> -->
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->unilevelIncome, 2) }}</span>
                            {{ Lang::get('labels.unilevel_income') }}
                        </div>
                    <!-- </div> -->
                </div>
            </div>
            <div class="row" style="margin-bottom: 50px;">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <div class="mini-stat clearfix bg-facebook rounded"> -->
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->pairingIncome, 2) }}</span>
                            {{ Lang::get('labels.pairing_income') }}
                        </div>
                    <!-- </div> -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <div class="mini-stat clearfix bg-facebook rounded"> -->
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->referralIncome, 2) }}</span>
                            {{ Lang::get('labels.direct_referral') }}
                        </div>
                    <!-- </div> -->
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <div class="mini-stat clearfix bg-twitter rounded"> -->
                        <span class="mini-stat-icon"><i class="fa fa-cubes fg-twitter"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->withdrawn, 2) }}</span>
                            {{ Lang::get('labels.withdrawn') }}
                        </div>
                    <!-- </div> -->
                </div>
                @if (config('system.show_ewallet'))
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <!-- <div class="mini-stat clearfix bg-twitter rounded"> -->
                            <span class="mini-stat-icon"><i class="fa fa-cube fg-facebook"></i></span>
                            <div class="mini-stat-info">
                                <span class="counter">{{ number_format($theUser->eWallet, 2) }}</span>
                                {{ Lang::get('labels.e_wallet') }}
                            </div>
                        <!-- </div> -->
                    </div>
                @endif
                @if (config('system.show_gc'))
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <!-- <div class="mini-stat clearfix bg-twitter rounded"> -->
                            <span class="mini-stat-icon"><i class="fa fa-cube fg-facebook"></i></span>
                            <div class="mini-stat-info">
                                <span class="counter">{{ number_format($theUser->gcIncome, 2) }}</span>
                                {{ Lang::get('labels.gc') }}
                            </div>
                        <!-- </div> -->
                    </div>
                @endif
            </div>
        </div>

        @if (isset($theUser->account->code->account_id))
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-theme rounded shadow">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ Lang::get('withdrawal.request') }}</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">{{ Lang::get('members.referral_link') }}</label>
                            <input class="form-control referral_link_box" type="text" value="{{ url(sprintf('auth/sign-up?ref=%s', $theUser->account->code->account_id)) }}"/>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop