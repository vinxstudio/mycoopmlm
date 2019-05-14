@extends('layouts.loginLayout')
@section('content')
    <div class="login-header">
        <div class="header-tagline">
        	<h1>Let's get started by joining <strong>As A Member</strong></h1>
        </div>
    </div>
    <div class="sign-up" id="sign-wrapper">

        {{ BootstrapAlert() }}
        <!-- Login form -->
        {{ Form::open([
                'url'=>url(sprintf('auth/sign-up%s', $suffix)),
                'class'=>'sign-in form-horizontal shadow rounded no-overflow'
            ]) }}
        <div class="col-md-6 col-xs-12">
			 @if(!Request::get('upgrade')) 
            <div class="sign-header">
                <div class="form-group">
                    <div class="sign-text">
							
				
                        <span>{{ Lang::get('labels.member_details') }}</span>
                    </div>
                </div><!-- /.form-group -->
            </div><!-- /.sign-header -->
            <div class="sign-body">
				@if(Request::get('node'))
				  
				 <div class="form-group">
                    {{ validationError($errors, 'have_activation') }}
                    <label class="control-label">New Own Account?</label>
                    <select class="form-control chosen-select to-disable" name="own_Account" id="own_Account">
						
					    <!--option value="left">Left</option><option value="right">Right</option-->
						@if ((Input::old('own_Account') == 'Other New Member Account') || ((Request::get('own_Account')  ==  'Other New Member Account')))
							<option value="Other New Member Account" selected>Other New Member Account</option>
						@else
							<option value="Other New Member Account">Other New Member Account</option>
						@endif
						@if ((Input::old('own_Account') == 'Own Account') || ((Request::get('own_Account')  ==  'Own Account')))
							<option value="Own Account" selected>Own Account</option>
							
						@else
							<option value="Own Account">Own Account</option>
						@endif
						
					</select>
					
                </div>
				@endif
				<div id="basic_profile_fields">
                @include('widgets.basic_signup_fields')
				</div>
            </div><!-- /.sign-body -->

        </div>
        <div class="col-md-6 col-xs-12">
		
            <div class="sign-header">
                <div class="form-group">
                    <div class="sign-text">
                        <span>{{ Lang::get('labels.account_details') }}</span>
                    </div>
                </div>
            </div>
			<div class="sign-body">
                
			</div>
            <div class="sign-body">
			     <input type="hidden" name="have_activation" value="yes">
				 
				 <input type="hidden" id="activateusername" name="forusername" value="{{ Request::get('theusername') }}">
			   
                <!--div class="form-group">
                    {{ validationError($errors, 'have_activation') }}
                    <label class="control-label">{{ Lang::get('members.have_activation') }}</label>
                    {{ Form::select('have_activation', [
                        'yes'=>Lang::get('labels.have_activation'),
                        'no'=>Lang::get('labels.no_activation')
                    ], old('have_activation'), [
                        'class'=>'form-control have_activation chosen-select',
                    ]) }}
                </div>
				<div class="form-group">
					 <label id="type-label" class="control-label">Membership Type:</label>
					 <select id="membership-toggle" class="chosen-select" name="type">
									@foreach($membership as $packages)
									<option value="{{ $packages->id }}">{{ $packages->membership_type_name }}</option>
									@endforeach
                                    <!--option value="free">Package B</option> 
									<option value="regular">Package C</option
                                    <!--option value="regular">Regular</option>
                                    <option value="free">Free</option-->
									
                     <!--/select>
				<!--/div-->
				
                <div class="form-group {{ ($referral != null) ? 'hidden' : '' }}">
                    {{ validationError($errors, 'upline_id') }}
                    <label class="control-label">{{ Lang::get('labels.upline_id') }}</label>
                    <p>Upline Name : <strong id="upline_name">{{ $upline_name }}</strong></p>
					<input type="text" class="form-control to-disable" name="upline_id" value="{{ old('upline_id', Request::get('uplineid'))  }}" readonly />
                    <!--{{ Form::text('upline_id', old('upline_id', $referral) , [
                        'class'=>'form-control to-disable' 
                    ]) }} -->
                </div>

                <div class="form-group {{ ($referral != null) ? 'hidden' : '' }}">
                    {{ validationError($errors, 'sponsor_id') }}
                    <label class="control-label">{{ Lang::get('labels.sponsor_id') }}</label>
                    <p>Sponsor Name : <strong id="sponsor_name">{{ $sponsor_name }}</strong></p>
					<input type="text" class="form-control to-disable" name="sponsor_id" value="{{ old('sponsor_id', Request::get('sponsorid'))  }}" />
                   
                    <!--{{ Form::text('sponsor_id', old('sponsor_id', $referral), [
                        'class'=>'form-control to-disable'
                    ]) }} -->
                </div>
                @include('FrontEnd.views.confirmation')
			@endif
                <div class="form-group">
                    {{ validationError($errors, 'account_id') }}
                    <label class="control-label">{{ Lang::get('labels.account_id') }}</label>
                    {{ Form::text('account_id', old('account_id'), [
                        'class'=>'form-control to-disable'
                    ]) }}
                </div>
			
                <div class="form-group">
                    {{ validationError($errors, 'activation_code') }}
                    <label class="control-label">{{ Lang::get('labels.activation_code') }}</label>
                    {{ Form::text('activation_code', old('activation_code'), [
                        'class'=>'form-control to-disable'
                    ]) }}
                </div>
			   @if(!Request::get('upgrade')) 
                <div class="form-group">
                    {{ validationError($errors, 'node_placement') }}
                    <label class="control-label">{{ Lang::get('members.node_placement') }}</label>
                    <!--{{ Form::select('node_placement', [
                        'left'=>Lang::get('labels.left'),
                        'right'=>Lang::get('labels.right')
                    ], old('node_placement'), [
                        'class'=>'form-control chosen-select to-disable',
                    ]) }} -->
					<select class="form-control chosen-select to-disable" name="node_placement">
						@if ((Input::old('node_placement') == 'left') || ((Request::get('node')  ==  'left')))
							<option value="left" selected>Left</option>
						@else
							<option value="left">Left</option>
						@endif
					    <!--option value="left">Left</option><option value="right">Right</option-->
						@if ((Input::old('node_placement') == 'right') || ((Request::get('node')  ==  'right')))
							<option value="right" selected>Right</option>
						@else
							<option value="right">Right</option>
						@endif
						
						</select>
					
                </div>
				@endif
            </div>
            <div class="sign-footer">
                <div class="form-group">
                    <button type="button" name="signup" id="sign-up" class="btn btn-theme btn-lg btn-block no-margin rounded spinner"> @if(!Request::get('upgrade')) {{ Lang::get('labels.sign_up') }} @else <p> Upgrade </p> @endif</button>
                </div>
            </div>
			@if(!Request::get('upgrade')) 
			@if (Request::get('node') == NULL)
            <!-- <div class="col-md-12 col-xs-12"> -->
                <p class="text-muted text-center sign-link" style="background-color: white; margin: 0; padding-bottom: 10px;">{{ Lang::get('labels.have_account') }} <a href="{{ url('auth/login#login') }}"> {{ Lang::get('labels.login') }}</a></p>
            <!-- </div> -->
			@endif
			@endif
            {{ Form::close() }}

            <!--/ Login form -->

    </div>
@stop

@section('pageIncludes')
    <script type="text/javascript">
        $(function(){
            $('.have_activation').on('change', function(){
                var selected = $(this).children('option:selected').val();

                if (selected == 'no'){
                    $('.to-disable').attr('disabled', true);
					$('#membership-toggle').attr('disabled', false);
					$('#membership-toggle').removeAttr('disabled');
					$('#membership-toggle').show();
					$('#type-label').show();
                } else {
                    $('.to-disable').removeAttr('disabled');
					$('#membership-toggle').attr('disabled', true);
					$('#membership-toggle').hide();
					$('#type-label').hide();
                }
            }).trigger('change');
			
			$('#own_Account').on('change', function(){
                var selected = $(this).children('option:selected').val();

                if (selected == 'Own Account'){
                    $('#basic_profile_fields').hide();
					$('#activateusername').show();
                } else {
                    $('#basic_profile_fields').show();
					$('#activateusername').hide();
                }
            }).trigger('change');

            $('input[name="sponsor_id"]').on("change", function(){
                var account_id = $('input[name="sponsor_id"]').val();
                $.ajax({ 
                    url: "<?php echo url('/') ?>/validateactivationcode/"+account_id, success:function(result){
                        if (result != "Account ID does not exist") {
                            $('#sign-up').attr('disabled', false);
                            $('#sponsor_name').html('<span class="text-success">'+result+'</span>');
                        }else{
                            $('#sign-up').attr('disabled', true);
                            $('#sponsor_name').html('<span class="text-danger">'+result+'</span>');
                        }
                    }
                });
            });

            $('button[name="signup"]').on('click', function(){ 
                $("#generateCodeModal").on("shown.bs.modal", function () {  //Tell what to do on modal open
                    var own_Account = $('#own_Account').val();
                    var c_fullname = $('input[name="first_name"]').val()+' '+ $('input[name="middle_name"]').val()+' '+$('input[name="last_name"]').val();
                    var c_username = $('input[name="username"]').val();
                    var c_email = $('input[name="email"]').val();

                    var c_upline_name = $('#upline_name').text();
                    var c_upline_id = $( 'input[name="upline_id"]' ).val();

                    var c_sponsor_name = $('#sponsor_name').text();
                    var c_sponsor_id = $('input[name="sponsor_id"]').val();

                    var c_account_id = $('input[name="account_id"]').val();
                    var c_activation_code = $('input[name="activation_code"]').val();

                    var c_placement = $('select[name="node_placement"]').val();
                    if(own_Account == 'Own Account'){
                        $('#own_acc').show();
                        $('#new_acc').hide();
                    }else{
                        $('#own_acc').hide();
                        $('#new_acc').show();

                        $('#c_fullname').text(c_fullname);
                        $('#c_email').text(c_email);
                        $('#c_username').text(c_username);
                    }
                    

                    $('#c_upline_name').text(c_upline_name);
                    $('#c_upline_id').text(c_upline_id);

                    $('#c_sponsor_name').text(c_sponsor_name);
                    $('#c_sponsor_id').text(c_sponsor_id);

                    $('#c_account_id').text(c_account_id);
                    $('#c_activation_code').text(c_activation_code);

                    $('#c_placement').text(c_placement);

                    $(this).appendTo("body");
                }).modal('show'); //open the modal once done
            });

            $('#submit-form').on('click',function(){
              $('.sign-in').submit();
            });
        })
    </script>
@stop