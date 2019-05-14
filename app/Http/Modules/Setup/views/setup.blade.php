@extends('layouts.setupLayout')
@section('content')
    <div class="col-md-6" id="setup">
        <div class="callout callout-info">
            <p class="lead">Setup your Company Details first then we'll move on to managing your business.</p>
        </div>

            <?php
               $theErrors = $errors->all();
            ?>
        @if (count($theErrors) > 0)
            <div class="callout callout-danger">
                <h4>Oops! Please review the fields stated below:</h4>
                <ul class="error-list">
                    @foreach ($theErrors as $message)
                        <li>{{ ucwords($message) }}</li>
                    @endforeach
                </ul>
                <div class="clearfix"></div>
            </div>
        @endif
        <!-- Start default tabs -->
        {{ Form::open() }}
        <div class="panel panel-tab rounded shadow">
            <!-- Start tabs heading -->
            <div class="panel-heading no-padding">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab1-1" data-toggle="tab">
                            <i class="fa fa-user"></i>
                            <span>Personal</span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab1-2" data-toggle="tab">
                            <i class="fa fa-bank"></i>
                            <span>Company</span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab1-3" data-toggle="tab">
                            <i class="fa fa-credit-card"></i>
                            <span>Membership Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab1-4" data-toggle="tab">
                            <i class="fa fa-check-circle"></i>
                            <span>Confirmation</span>
                        </a>
                    </li>
                </ul>
            </div><!-- /.panel-heading -->
            <!--/ End tabs heading -->

            <!-- Start tabs content -->
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1-1">
                        @include('Setup.views.partial.personalDetails')
                    </div>
                    <div class="tab-pane fade" id="tab1-2">
                        @include('Setup.views.partial.companyDetails')
                    </div>
                    <div class="tab-pane fade" id="tab1-3">
                        @include('Setup.views.partial.membershipDetails')
                    </div>
                    <div class="tab-pane fade" id="tab1-4">
                        <h4>Confirmation content</h4>
                        @include('Setup.views.partial.reviewDetails')
                        {{ Form::button('Save Details', [
                            'class'=>'btn btn-primary pull-right',
                            'type'=>'submit',
                            'name'=>'save-details',
                            'value'=>'save-details'
                        ]) }}
                    </div>
                </div>
            </div>
            <!--/ End tabs content -->
        </div>
        {{ Form::close() }}
    </div>
@stop

@section('custom_includes')
    {{ Html::style('public/custom/css/setup.css') }}
    {{ Html::script('public/custom/js/setup.js') }}
@stop