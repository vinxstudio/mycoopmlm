<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 11:26 AM
 */

namespace App\Http\Modules\Admin\PointsSummary\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Accounts;
use App\Models\User;
use App\Models\ActivationCodes;
use App\Models\UserDetails;
use App\Models\Withdrawals;
use App\Models\ForMaintenance;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use App\Models\Downlines;
use App\Models\Membership;
use App\Models\Details;
use App\Models\PointsSummary;
use App\Models\PointsDetails;
use App\Models\EarningsPairing;


class PointsSummaryController extends AdminAbstract{

    protected $viewpath = 'Admin.PointsSummary.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex($keyword = null){
         
        $points_summary_model = new PointsSummary();
        $details = $points_summary_model->getPointsValue();
        if ($keyword != null){
            $collectedUserId = [0];

            $q1 = Details::where('first_name', 'like', '%'.$keyword.'%')
            ->orWhere('last_name', 'like', '%'.$keyword.'%')->get();

            $detailsId = [0];

            foreach ($q1 as $q1row){
                $detailsId[] = $q1row->id;
            }

            $activationCodes = ActivationCodes::where('account_id', 'like', '%'.$keyword.'%')->where('status', 'used')->get();

            $activationIds = [];

            foreach ($activationCodes as $row){
                $activationIds[] = $row->id;
            }

            if (count($activationIds) > 0) {
                $accounts = Accounts::whereIn('code_id', $activationIds)->get();
                foreach ($accounts as $acc){
                    $collectedUserId[] = $acc->user_id;
                }
            }

            $details->where('users.username', 'like', '%'.$keyword.'%')->where('role', 'member')
                    ->orWhereIn('users.id', $collectedUserId)->where('role', 'member')
                    ->orWhereIn('user_details_id', $detailsId)->where('role', 'member');
        }

        $lists = $details->paginate(50);

        return view( $this->viewpath . 'index')
                ->with([
                    'lists' => $lists,
                ]);
                
        
    }
    function postIndex(Request $request)
    {   

        if(!empty($request->input('search')) ) {
            return redirect('/admin/points-summary/index/'.$request->input('search'));
        }
    }

    function getDownline(Request $request)
    {   
        $segment = 'downline';
        $downlines = new Downlines();

        $left_downlines = $downlines->getDownlines($request->account_id, 'left');
        $right_downlines = $downlines->getDownlines($request->account_id, 'right');

        $left_total_points = $downlines->getTotalPV($request->account_id, 'left');
        $right_total_points = $downlines->getTotalPV($request->account_id, 'right');

       
        $user_info = $this->getUserInfo($request->account_id);
		
        
        return view( $this->viewpath . 'show_downline')
                ->with([
                    'user_info' => $user_info,
                    'left_downlines' => $left_downlines,
                    'right_downlines' =>$right_downlines,
                    'left_total_points' => $left_total_points,
                    'right_total_points' => $right_total_points,
                    'segment'   => $segment
                ]);
    }

    function getPairing(Request $request){

        $segment = 'pairing';
        $payout = array();

		$q = EarningsPairing::whereIn('source', ['pairing','GC'])
                        ->where('account_id', $request->account_id);
        
        $total_mb = EarningsPairing::where('source', 'pairing')
                        ->where('account_id', $request->account_id)
                        ->sum('amount');

        $total_gc = EarningsPairing::where('source', 'GC')
                    ->where('account_id', $request->account_id)
                    ->sum('amount');

        $user_info = $this->getUserInfo($request->account_id);
		// if(!empty($from)) $q->whereDate('earnings.earned_date', '>=', $from);
		// if(!empty($to)) $q->whereDate('earnings.earned_date', '<=', $to);

		$earnings = $q->orderBy('id','ASC')->get();

    	foreach ($earnings as $earning) {
    		$l_account = Accounts::find($earning->left_account_id);
    		$l_user = User::find($l_account->user_id);
    		$l_user_details = Details::find($l_user->user_details_id);
    		$l_membership = Membership::find($l_user->member_type_id);
    		$l_activationcode = ActivationCodes::where('user_id',$l_user->id)->first();
		

    		$r_account = Accounts::find($earning->right_account_id);
    		$r_user = User::find($r_account->user_id);
    		$r_user_details = Details::find($r_user->user_details_id);
    		$r_membership = Membership::find($r_user->member_type_id);
    		$r_activationcode = ActivationCodes::where('user_id',$r_user->id)->first();

    		$payout[] = [
				'left_account_id' => $l_activationcode->account_id,
				'left_name' => $l_user_details->first_name.' '.$l_user_details->last_name,
				'left_package' => $l_membership->membership_type_name,
				'left_account_date' => $l_account->created_at,

				'right_account_id' => (!empty($r_activationcode))?$r_activationcode->account_id:'',
				'right_name' => $r_user_details->first_name.' '.$r_user_details->last_name,
				'right_package' => $r_membership->membership_type_name,
				'right_account_date' =>$r_account->created_at,

                'source'    => $earning->source,
				'mb' => ($earning->amount == 1)? 0 : $earning->amount,
				'date' => $earning->earned_date,
				
				];
		}	

		return view( $this->viewpath . 'show_pairing' )
            ->with([
                'payments'=>$payout,
                'user_info'=>$user_info,
                'total_mb' => ($total_mb) ? number_format($total_mb, 2): '0.00',
                'total_gc' => ($total_gc) ? number_format($total_gc, 2): '0.00',
                'segment' => $segment
            ]);
    
    }
    function getDetails(Request $request)
    {   
        $segment = 'details';
        $pv = new PointsDetails();

        $details = $pv->getDetails($request->account_id);

        $user_info = $this->getUserInfo($request->account_id);
        // return $details;
        return view( $this->viewpath . 'show_details')
                    ->with([
                        'user_info' => $user_info,
                        'details' => $details,
                        'segment' => $segment
                    ]);
               
    }
    function getUserInfo($account_id){

        $user_account = Accounts::find($account_id);
    	$user = User::find($user_account->user_id);
		$activationcode = ActivationCodes::where('user_id',$user->id)->first();
		$membership = Membership::find($user->member_type_id);
        $fullname = Details::find($user->user_details_id);
        
        $user_info = array(
            'code' => $activationcode->code,
            'accountid' => $activationcode->account_id,
            'username' => $user->username,
            'fullname' => $fullname->first_name.' '.$fullname->last_name,
            'package' => $membership->membership_type_name,
            
        );

        return $user_info;
    }
      
}
