@extends('layouts.members')
@section('content')
<style>



.popupContainer {
		position: absolute;
		width: 330px;
		height: auto;
		left: 45%;
		top: 60px;
		background: #FFF;
}

#modal_trigger {
		margin: 40px auto;
		width: 200px;
		display: block;
		border: 1px solid #DDD;
		border-radius: 4px;
}

.btn {
		padding: 10px 20px;
		background: #F4F4F2;
}

.btn_red {
		background: #ED6347;
		color: #FFF;
}

.btn:hover {
		background: #E4E4E2;
}

.btn_red:hover {
		background: #C12B05;
}

a.btn {
		color: #666;
		text-align: center;
		text-decoration: none;
}

a.btn_red {
		color: #FFF;
}

.one_half {
		width: 50%;
		display: block;
		float: left;
}

.one_half.last {
		width: 45%;
		margin-left: 5%;
}
/* Popup Styles*/

.popupHeader {
		font-size: 16px;
		text-transform: uppercase;
}

.popupHeader {
		background: #F4F4F2;
		position: relative;
		padding: 10px 20px;
		border-bottom: 1px solid #DDD;
		font-weight: bold;
}

.popupHeader .modal_close {
		position: absolute;
		right: 0;
		top: 0;
		padding: 10px 15px;
		background: #E4E4E2;
		cursor: pointer;
		color: #aaa;
		font-size: 16px;
}

.popupBody {
		padding: 20px;
}
/* Social Login Form */

.social_login {}

.social_login .social_box {
		display: block;
		clear: both;
		padding: 10px;
		margin-bottom: 10px;
		background: #F4F4F2;
		overflow: hidden;
}

.social_login .icon {
		display: block;
		width: 10px;
		padding: 5px 10px;
		margin-right: 10px;
		float: left;
		color: #FFF;
		font-size: 16px;
		text-align: center;
}

.social_login .fb .icon {
		background: #3B5998;
}

.social_login .google .icon {
		background: #DD4B39;
}

.social_login .icon_title {
		display: block;
		padding: 5px 0;
		float: left;
		font-weight: bold;
		font-size: 16px;
		color: #777;
}

.social_login .social_box:hover {
		background: #E4E4E2;
}

.centeredText {
		text-align: center;
		margin: 20px 0;
		clear: both;
		overflow: hidden;
		text-transform: uppercase;
}

.action_btns {
		clear: both;
		overflow: hidden;
}

.action_btns a {
		display: block;
}
/* User Login Form */

.user_login {
		display: none;
}

.user_login label {
		display: block;
		margin-bottom: 5px;
}

.user_login input[type="text"],
.user_login input[type="email"],
.user_login input[type="password"] {
		display: block;
		width: 90%;
		padding: 10px;
		border: 1px solid #DDD;
		color: #666;
}

.user_login input[type="checkbox"] {
		float: left;
		margin-right: 5px;
}

.user_login input[type="checkbox"]+label {
		float: left;
}

.user_login .checkbox {
		margin-bottom: 10px;
		clear: both;
		overflow: hidden;
}

.forgot_password {
		display: block;
		margin: 20px 0 10px;
		clear: both;
		overflow: hidden;
		text-decoration: none;
		color: #ED6347;
}
/* User Register Form */

.user_register {
		display: none;
}

.user_register label {
		display: block;
		margin-bottom: 5px;
}

.user_register input[type="text"],
.user_register input[type="email"],
.user_register input[type="password"] {
		display: block;
		width: 90%;
		padding: 10px;
		border: 1px solid #DDD;
		color: #666;
}

.user_register input[type="checkbox"] {
		float: left;
		margin-right: 5px;
}

.user_register input[type="checkbox"]+label {
		float: left;
}

.user_register .checkbox {
		margin-bottom: 10px;
		clear: both;
		overflow: hidden;
}
</style>
   
    @if (count($viewed) > 0)
        <div class="">
            <ul class="breadcrumb">
                <li>
                    <a href="{{ url('member/network-tree') }}">You : {{ $theUser->account->code->account_id }}</a>
                </li>
                @foreach ($viewed as $userID)
                    <li>
                        <a href="{{ url(sprintf('member/network-tree/index/%s-%s', strtoupper($listedUser[$userID]->account->code->account_id), $userID)) }}">{{ strtoupper($listedUser[$userID]->account->code->account_id) }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ Html::style('public/plugins/jquery-orgchart/jquery.orgchart.css') }}
    <!-- <ul id="chart" class="hidden">
            <li class="binary code-{{ $currentUser->account->type or 'free' }}">
                <img src="{{ url($currentUser->details->thePhoto) }}" width="80" height="80">
                <span class="owner-name">{{ $currentUser->details->fullName }}</span>
                <span class="account-id">{{ $currentUser->account->code->account_id }}</span>
                <ul>
                    {{ $binaryTree }}
                </ul>

            </li>
    </ul>
    <div id="main"></div> -->
<?php $today = getdate(); ?>
<script>
    var d = new Date(<?php echo $today['year'].",".$today['mon'].",".$today['mday'].",".$today['hours'].",".$today['minutes'].",".$today['seconds']; ?>);
    setInterval(function() {
        d.setSeconds(d.getSeconds() + 1);
        $('#timer').text((d.getHours() +':' + d.getMinutes() + ':' + d.getSeconds() ));
    }, 1000);
</script> 
<label id="date">Server Date Time: <?php echo $today['year']."-".$today['mon']."-".$today['mday']; ?></label>
<label id="timer"></label>
<div class="container">

        <ul id="chart" class="hidden">
		
                <li style="background-color:{{ $color }}" class="binary code-"> {{ $currentUser->account->code->type }}
				    </br> Level {{ $level }}
                    <img src="{{ url($currentUser->details->thePhoto) }}" width="80" height="80">
                    <span class="owner-name">{{ $currentUser->details->fullName }}</span>
                    <span style='font-size:10px' class="account-id">ID: {{ $currentUser->account->code->account_id }}</span> </br>
				@if ( $colorFlag == 1)	
					<span style='font-size:10px' class="mb">AR: {{ $countRB }}</span> 
				@else
					<span style='font-size:10px' class="mb">MB: {{ $countMB }}</span> </br>
					<span style='font-size:10px' class="dr">DR: {{ $countDR }}</span> </br>
					<span style='font-size:10px' class="pv">LPV: {{ $countLPV }}</span> </br>
					<span style='font-size:10px' class="pv">RPV: {{ $countRPV }}</span> </br>
                @endif 
				   <ul>
					
                        {{$binaryTree}}
						
						                        
                    </ul>
                </li>
        </ul>
		
    <div id="main"></div>
	
		
		
</div>

<div>

  <!--table class="dataTable table table-bordered table-hover table-striped">

        <thead>
             @if ($company->multiple_account > 0)
                <th class="hidden-xs">{{ Lang::get('members.id') }}</th>
            @endif
            <th class="hidden-xs">{{ Lang::get('members.referral_link') }}</th>
            <th class="hidden-xs">{{ Lang::get('members.upline') }}</th>
          
            <th class="hidden-xs">{{ Lang::get('members.earned') }}</th>
            @if ($company->multiple_account <= 0)
                <th class="hidden-xs">{{ Lang::get('members.accounts_owned') }}</th>
            @endif
            <th class="hidden-xs">{{ Lang::get('members.direct_referral') }}</th>
            <th>{{ Lang::get('labels.action') }}</th>
        </thead>

        <tbody>

			@foreach ($members as $member)
                    <tr>
                        @if ($company->multiple_account > 0)
                            <td class="hidden-xs">{{ strtoupper(@$member->account->code->account_id) }}</td>
                        @endif
                         <td class="hidden-xs"><a href="{{ url(sprintf('auth/sign-up?ref=%s', isset($member->account->code->account_id) ? $member->account->code->account_id : null)) }}" target="_blank">{{ sprintf('?ref=%s', isset($member->account->code->account_id) ? $member->account->code->account_id : '') }}</a></td>
                        <td class="hidden-xs">{{ $member->account->uplineUser->username or '' }} <br/> {{ (isset($member->account->uplineUser->id)) ? sprintf('(%s)', strtoupper($member->account->uplineUser->account->code->account_id)) : null }}</td>
                        
                        <td class="hidden-xs">{{ number_format($member->earnings, 2) }}</td>
                        @if ($company->multiple_account <= 0)
                            <td class="hidden-xs">{{ $member->accounts->count() }}</td>
                        @endif
                        <td class="hidden-xs">{{ $member->directReferral->count() }}</td>
                        <td>
                            <a class="btn btn-danger btn-xs" href="{{ url('member/network-tree/login/'.$member->id) }}"><i class="fa fa-login"></i> Login</a>
                        </td>
                    </tr>
                @endforeach
		 </tbody>

    </table-->

</div>



@stop

@section('custom_includes')
    {{ Html::script('public/plugins/jquery-orgchart/jquery.orgchart.min.js') }}
	<script>
	function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=800,left = 283,top = -16');");

}
function popUp2(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=400,left = 283,top = -16');");

}
	$(document).on('click', '#modal_trigger', function(e) {
    e.preventDefault();
   
   $(".user_register").show();
				$(".header_title").text('Register');
				return false;
  });
	
	
	
	
	$(document).ready(function(){
   $('.ViewImage').on('click',function(){
       // some code is executed which brings up the popup 
       // now we know that the image is added into html we can now run the script
    $("#modal_trigger").click(function (){
       //your logic here
	   $(".user_register").show();
				$(".header_title").text('Register');
				return false;
	   
     });
   });
});
  
  </script>
<script src='https://andwecode.com/wp-content/uploads/2015/10/jquery.leanModal.min_.js'></script>
    <script type="text/javascript">
        $("#chart").orgChart({container: $("#main")});
		// Plugin options and our code
$("#modal_trigger").leanModal({
		top: 100,
		overlay: 0.6,
		closeButton: ".modal_close"
});

$(function() {
		

		
				$(".user_register").show();
				$(".header_title").text('Register');
				return false;
		
});
    </script>
@stop