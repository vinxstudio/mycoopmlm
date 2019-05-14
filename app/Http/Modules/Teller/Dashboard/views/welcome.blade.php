@extends('layouts.master')
@section('content')
    <div id="tour-12" class="row">
        <div class="row" style="margin-top: 25px; margin-bottom: 25px;">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <!-- <div class="mini-stat clearfix bg-facebook rounded"> -->
                    <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                    <div class="mini-stat-info">
                        <span class="counter">{{ number_format($company->remainingBalance, 2) }}</span>
                        Company Income
                    </div>
                <!-- </div> -->
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <!-- <div class="mini-stat clearfix bg-twitter rounded"> -->
                    <span class="mini-stat-icon"><i class="fa fa-cubes fg-twitter"></i></span>
                    <div class="mini-stat-info">
                        <span class="counter">{{ number_format($codes->count()) }}</span>
                        Activation Codes
                    </div>
                <!-- </div> -->
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <!-- <div class="mini-stat clearfix bg-googleplus rounded">-->
                    <span class="mini-stat-icon"><i class="fa fa-user fg-googleplus"></i></span>
                    <div class="mini-stat-info">
                        <span class="counter">{{ number_format($members->count()) }}</span>
                        Registered Members
                    </div>
                <!-- </div> -->
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <!-- <div class="mini-stat clearfix bg-bitbucket rounded"> -->
                    <span class="mini-stat-icon"><i class="fa fa-clone fg-bitbucket"></i></span>
                    <div class="mini-stat-info">
                        <span class="counter">{{ number_format($accounts->count()) }}</span>
                        Member Accounts
                    </div>
                <!-- </div> -->
            </div>
        </div>
        <div class="row" style="margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid #ddd">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <!-- <div class="mini-stat clearfix bg-bitbucket rounded"> -->
                    <span class="mini-stat-icon"><i class="fa fa-clone fg-googleplus"></i></span>
                    <div class="mini-stat-info">
                        <span class="counter">{{ (isset($carries['left'])) ? count($carries['left']) : 0 }}</span>
                        {{ Lang::get('labels.carry_left') }}
                    </div>
                <!-- </div> -->
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <!-- <div class="mini-stat clearfix bg-bitbucket rounded"> -->
                    <span class="mini-stat-icon"><i class="fa fa-clone fg-bitbucket"></i></span>
                    <div class="mini-stat-info">
                        <span class="counter">{{ isset($carries['right']) ? count($carries['right']) : 0 }}</span>
                        {{ Lang::get('labels.carry_right') }}
                    </div>
                <!-- </div> -->
            </div>
        </div>

        @if (!$connections->isEmpty())
            @foreach ($connections as $connect)
                <?php
                    $curl = file_get_contents($connect->url . '/json-connection/' . $connect->passcode);
                    $result = json_decode($curl);
                ?>
                @if ($result != NULL)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="panel panel-theme">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">{{ $result->company->name }}</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table">
                                    <tr>
                                        <td>{{ Lang::get('labels.system') }}</td>
                                        <td>{{ $result->company->app_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ Lang::get('labels.company_earnings') }}</td>
                                        <td>{{ number_format($result->earnings, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ Lang::get('labels.carry_left') }}</td>
                                        <td>{{ isset($result->carries->left) ? count($result->carries->left) : 0 }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ Lang::get('labels.carry_right') }}</td>
                                        <td>{{ isset($result->carries->right) ? count($result->carries->right) : 0 }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

@stop

@section('custom_includes')

@stop