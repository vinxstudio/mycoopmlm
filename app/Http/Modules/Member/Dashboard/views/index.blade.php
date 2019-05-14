@extends('layouts.members')
@section('content')
    <style>
        .carousel-control .glyphicon-chevron-left{
            left: 20%!important;
        }

        .carousel-control .glyphicon-chevron-right{
            right: 20%!important;
        }

        .carousel-inner{
            color: #fff;
        }

        .modal-body {
            overflow-y: auto;
            height: 75%;
        }
        
        .modal-backdrop{
            position: unset;
        }


        .announcement_view{
            position: absolute;
            bottom: 5%;
            right: 45%;
        }

        .a_body:not(:last-child){
            border-bottom: 2px solid #dcdcdc;
            padding-bottom: 15px;
        }
        .item h2, .item h3 {
            margin-top: 5px;
            line-height: normal;
        }

        .item h2 {
            color: #400D12;
            font-weight: bold;
        }

        .item div{
            text-align: left;
            padding: 0 45px 0 45px;
        }
    </style>
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
        <!--div class="mini-stat-wrap" style="margin-bottom: 25px; border-bottom: 1px solid #ddd;">
            <div class="row" style="margin-bottom: 50px;">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <span class="mini-stat-icon"><i class="fa fa-money fg-googleplus"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->remainingBalance, 2) }}</span>
                            {{ Lang::get('labels.remaining_balance') }}
                        </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->earnings, 2) }}</span>
                            {{ Lang::get('labels.total_income') }}
                        </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->rebatesIncome, 2) }}</span>
                            {{ Lang::get('labels.rebates_income') }}
                        </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->unilevelIncome, 2) }}</span>
                            {{ Lang::get('labels.unilevel_income') }}
                        </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 50px;">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->pairingIncome, 2) }}</span>
                            {{ Lang::get('labels.pairing_income') }}
                        </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <span class="mini-stat-icon"><i class="fa fa-money fg-facebook"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->referralIncome, 2) }}</span>
                            {{ Lang::get('labels.direct_referral') }}
                        </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <span class="mini-stat-icon"><i class="fa fa-cubes fg-twitter"></i></span>
                        <div class="mini-stat-info">
                            <span class="counter">{{ number_format($theUser->withdrawn, 2) }}</span>
                            {{ Lang::get('labels.withdrawn') }}
                        </div>
                </div>
                @if (config('system.show_ewallet'))
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <span class="mini-stat-icon"><i class="fa fa-cube fg-facebook"></i></span>
                            <div class="mini-stat-info">
                                <span class="counter">{{ number_format($theUser->eWallet, 2) }}</span>
                                {{ Lang::get('labels.e_wallet') }}
                            </div>
                    </div>
                @endif
                @if (config('system.show_gc'))
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <span class="mini-stat-icon"><i class="fa fa-cube fg-facebook"></i></span>
                            <div class="mini-stat-info">
                                <span class="counter">{{ number_format($theUser->gcIncome, 2) }}</span>
                                {{ Lang::get('labels.gc') }}
                            </div>
                    </div>
                @endif
            </div>
        </div-->
       <?php $total_GI = $t_mb + $t_dr;  ?>
        <div class="col-md-12">
            <div class="col-md-6 text-center dashboard" style="background-color: #00B1E1; color:#ffffff; padding-bottom: 20px; margin-bottom: 30px;">
                <div>
                    <h1>{{ strtoupper($theDetails->first_name.' '.$theDetails->middle_name.' '.$theDetails->last_name) }}</h1>
                </div>
                <div class="col-md-12">
                    <div class="col-md-5 text-right"><h4>All Total Earnings : </h4></div>
                    <div class="col-md-7 text-left"><h4>PHP {{ number_format($total_GI, 2) }}</h4></div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-5 text-right"><h5>Available Balance : </h5></div>
                    <div class="col-md-3 text-left"><h5>PHP {{ number_format(($available_balance < 0)?0:$available_balance, 2) }}</h5></div>
                    <div class="col-md-4">
                        <a href="withdrawals/request" class="btn btn-success  text-center col-md-12">Encash Balance</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-5 text-right"><h5>All Giftcheck Rewards Balance : </h5></div>
                    <div class="col-md-3 text-left"><h5>{{ $t_gc.' GC ('.number_format(($total_value_gc < 0)?0:$total_value_gc, 2).')' }}</h5></div>
                    <div class="col-md-4">
                        <a href="/member/giftcheck" class="btn btn-success  text-center col-md-12 ">Transfer Gift Check</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-5 text-right"><h5>Redundant Binary Income : </h5></div>
                    <div class="col-md-3 text-left"><h5>PHP {{ number_format($redundant_binary_income, 2) }}</h5></div>
                    <div class="col-md-4">
                        <a href="/member/encash-redundant" class="btn btn-success  text-center col-md-12 ">Encash Income</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" style="background-color: #24c8f0;">
                        @if($announcement)
                            @foreach($announcement as $index => $val)
                                <div class="item {{ $index == 0 ? 'active' : '' }}">
                                    <h2>ANNOUNCEMENT</h2>
                                    <h3>{{ str_limit($val->announcement_title, 40) }}</h3>
                                    <div>{{ str_limit(strip_tags($val->announcement_details), 300) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="item active">
                                <h1>NO ANNOUNCEMENT</h1>
                            </div>
                        @endif
                        <div class="announcement_view" data-toggle="modal" data-target="#view_announcement">
                            <button class="btn btn-success">View all</button>
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="background-image: none">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next" style="background-image: none">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
            <div class="col-md-12" >
                <div class="col-md-6 col-sm-12" style="margin-left: -20px;"><h4>All Account Weekly Income</h4></div>
                <div class="col-md-6 col-sm-12">
                    <a href="{{ url(Request::segment(1).'/profile') }}" class="btn btn-info pull-right" style="margin-right: -40px;"><i class="fa fa-user"></i>  Update Profile</a>
                </div>
            </div>
			<div><span>CUTOFF PERIOD:  
                <?php
echo $startDate . " 06:01am - " . $endDate . " 05:59am" ?> </span> <span style=" float:right ">ACCOUNT STATUS: Active</span>  </div>
			  <table class="table table-bordered table-striped">
				<tr>
					<td>Direct Referral Income</td>
					<td>Match Sales Bonus Income</td>
					<td>Gift Certificate</td>
                    <td>Unilevel Income</td>
					<td>Number of Pairings</td>
					<td>Gross Income</td>
				</tr>
				<tr>
					<!-- <td>{{ number_format($theUser->referralIncome, 2) }}</td>
                    <td>{{ number_format($theUser->pairingIncome, 2) }}</td>
                    <td>{{ number_format($theUser->gcIncome, 2) }}</td>
                    <td>{{ number_format($theUser->unilevelIncome, 2) }}</td>
                    <td>{{ number_format($theUser->earnings, 2) }}</td> -->

                    <td>{{ number_format($DRI, 2) }}</td>
					<td>{{ number_format($MSBI, 2) }}</td>
					<td>{{ number_format($GC, 2) }}</td>
                    <td>{{ number_format($unilevel, 2) }}</td>
					<td>{{ number_format($NMSBI, 0) }}</td>
					<td>{{ number_format($GI, 2) }}</td>
				</tr>
				
			  </table>
                <div>
                    

                    <span class="pull-left">
                         @if($start <= -2 && $end <= -1)
                             {{ Form::open([ 'class'=>'form-inline']) }}
                             <?php $c_end = ($end == -1)? +1 : $end + 1; ?>
                             <input type="hidden" name="prev" value="0">
                             <input type="hidden" name="start" value="{{ ($start+1) }}">
                             <input type="hidden" name="end" value="{{ ($c_end ) }}"> 
                             <input type="submit" class="btn btn-primary" value="TO CURRENT CUTOFF"> 
                             {{ Form::close() }} 
                         @endif
                    </span>
                    <span class="pull-right">

                         {{ Form::open([ 'class'=>'form-inline']) }}
                             <?php $p_end = ($end <= 0)? -2 : $end - 2; ?>
                             <input type="hidden" name="prev" value="1">
                             <input type="hidden" name="start" value="{{ ($start-1) }}">
                             <input type="hidden" name="end" value="{{ $p_end }}"> 
                             <input type="submit" class="btn btn-primary" value="TO PREVIOUS CUTOFF"> 
                         {{ Form::close() }} 
                    </span>
	            </div> 
			</div>
		</br></br>
			<!-- <div><span>NETWORK STANDING & ACHIEVEMENTS </div>
			  <table class="table table-bordered table-striped">
				<tr>
					<td>GROSS INCOME</td>
					<td>TRAVEL INCENTIVE</td>
					<td>CAR PROGRAM</td>
					<td>MEMBERSHIP RANK</td>
				</tr>
				<tr>
					<td>{{ number_format($theUser->earnings, 2) }}</td>
					<td>NONE</td>
					<td>NONE</td>
					<td>RISING STAR</td>
				</tr>
				
			  </table>
	
			</div> -->
		      <span><h4>All Account Overall Income Summary</h4></span>
			  <table class="table table-bordered table-striped">
				<tr>
					<td>Direct Referral Accumulated Income</td>
                    <td>{{ number_format($t_dr, 2) }}</td>
					<!-- <td>{{ number_format($theUser->referralIncome, 2) }}</td> -->
				</tr>
				
				<tr>
					<td>Match Bonus Accumulated Income</td>
                    <td>{{ number_format($t_mb, 2) }}</td>
					<!-- <td>{{ number_format($theUser->pairingIncome, 2) }}</td> -->
				</tr>
				
				<tr>
					<td>Gift Check Accumulated Income</td>
                    <td>{{ $t_gc.' GC ('.number_format($total_value_gc, 2).')' }}</td>
					<!-- <td>{{ number_format($theUser->gcIncome, 2) }}</td> -->
				</tr>
			
				<tr>
					<td>Unilevel Accumulated Income</td>
					<td>{{ number_format($theUser->UnilevelIncentives, 2) }}</td>
				</tr>
                <tr>
                </tr>
				<tr>
                    
					<td>GROSS INCOME</td>
                    <td>{{ number_format($total_GI, 2) }}</td>
                </tr>
			
				
			  </table>
	
			</div>
           </br></br>
            {{ view('Member.Dashboard.views.accountSummary')
                ->with([
                    'account_summary' => $account_summary
                ])->render(); 
            }}

			</br>
        @if (isset($theUser->account->code->account_id))
            <!--div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-theme rounded shadow">
                    <div class="panel-heading">
                        <h3 class="panel-title">Referral Link</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">{{ Lang::get('members.referral_link') }}</label>
                            <input class="form-control referral_link_box" type="text" value="{{ url(sprintf('auth/sign-up?ref=%s', $theUser->account->code->account_id)) }}"/>
                        </div>
                    </div>
                </div>
            </div-->
        @endif
    </div>

    <div class="modal fade" id="view_announcement" role="dialog">
        <div class="modal-dialog modal-lg">
            
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center">Announcement</h4>
                </div>
                <div class="modal-body">
                    @foreach($announcement as $index => $val)
                        <div class="a_body">
                            <h3 class="a_title">{{ $val->announcement_title }}</h3>
                            <div class="a_details">{{ $val->announcement_details }}</div>
                            <div class="a_posted">Posted Date: {{$val->display_date}}</div>
                            <div class="a_created">By:{{ $val->announcement_from }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Close</button>
                </div>
            </div>
          
        </div>
    </div>

    <div class="modal fade" id="modal_coop_id" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-md">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-danger" >Please Enter Your Coop Id.</h4> 
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" name="coop_id" id="coop_id" placeholder="xxxx-xxxxxxx-x">
                    <span class="text-danger" id="error_coop_id"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="submit-coop-id">Submit</button>
                </div>
            </div>
          
        </div>
    </div>

    <script type="text/javascript">
        var maxheight = 0;

        $('.dashboard').each(function () {
            maxheight = ($(this).height() > maxheight ? $(this).height() : maxheight);
        });
        
        $('.carousel-inner').height(maxheight + 20);

        //get coop id
        let coop_id = "{{$theDetails->coop_id}}";
        if( !coop_id ) {
            $(window).on('load',function(){
                $('#modal_coop_id').modal('show');
            });
        }

        $(document).on('click', '#submit-coop-id', function(e){
            e.preventDefault();
            let coop_id = $('#coop_id').val();
            let id = "{{$theDetails->id}}";
            if( !coop_id ) {
                $('#error_coop_id').text('This field is required.');
            } else {
                insertCoopId(coop_id, id);
            }
            
        })


        function insertCoopId(val, id) {
            $.ajax({
                type: 'POST',
                url: "dashboard/coop-id",
                data: {
                    coop_id : val,
                    id      : id,
                },
                success : function(data){
                    $('#modal_coop_id').modal('hide');
                    if (data.error) {
                        alert(data.error);
                        return false;
                    }

                    alert(data.message);
                }
            });
        }
        
    </script>

@stop