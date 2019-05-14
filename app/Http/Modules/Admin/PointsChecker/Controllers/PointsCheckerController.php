<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 11:26 AM
 */

namespace App\Http\Modules\Admin\PointsChecker\Controllers;

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

class PointsCheckerController extends AdminAbstract{

    protected $viewpath = 'Admin.PointsChecker.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex($id = null){
            
        $left_total = 0;
        $right_total = 0;
        $total_remaining_pv = 0;
        $strong_leg = 'none';
        $cd_ids = array();

        // $user_account = Accounts::find($id);
    	// $user = User::find($user_account->user_id);
		// $activationcode = ActivationCodes::where('user_id',$user->id)->first();
		// $membership = Membership::find($user->member_type_id);
		// $fullname = Details::find($user->user_details_id);

		// $user_info = array(
		// 		'code' => $activationcode->code,
		// 		'accountid' => $activationcode->account_id,
		// 		'username' => $user->username,
		// 		'fullname' => $fullname->first_name.' '.$fullname->last_name,
		// 		'package' => $membership->membership_type_name,
		// );
        
        $lists = Downlines::where('parent_id', $id)->paginate(50);
        
        $total_pv = Downlines::where('parent_id', $id)->get();

        foreach($total_pv as $pv)
        {
            $l_activationcode = ActivationCodes::where('id',$pv->code_id)->first();
            $l_user = User::find($l_activationcode->user_id);    
            if($l_user)
            {
                
                $l_user_details = Details::find($l_user->user_details_id);
                $l_membership = Membership::find($l_user->member_type_id);

                if($l_user->member_type_id > 3)
                {
                    $cd_ids[] = $pv->account_id;
                }
                else
                {
                    if($pv->node == 'left')
                    {
                        $left_total = $left_total + $l_membership->points_value;
                    }
                    else
                    {
                        $right_total = $right_total + $l_membership->points_value;
                    }
                }

            }
           
           
        }

        if ($right_total > $left_total)  {
            $right_total = $right_total - $left_total;
            $left_total = 0;
            $strong_leg = 'right';
        }
        else if ($left_total > $right_total)  {
            $left_total = $left_total - $right_total;
            $right_total = 0;
            $strong_leg = 'left';
        }
        else
        {
            $left_total = 0;
            $right_total = 0;
            $strong_leg = 'none';
        }
        $pv_table[] = [
            'left_total_pv' => $left_total,
            'right_total_pv' => $right_total,
            'strong_leg'    => $strong_leg
            
        ];
   
        foreach($lists as $list)
        {
                $l_activationcode = ActivationCodes::where('id',$list->code_id)->first();
                $l_user = User::find($l_activationcode->user_id);    
                if($l_user)
                {
                    
                    $l_user_details = Details::find($l_user->user_details_id);
                    $l_membership = Membership::find($l_user->member_type_id);

                    if($l_user->member_type_id > 3)
                    {
                        $points_value = 0;
                    }
                    else
                    {
                        $points_value = $l_membership->points_value;
                    }
                    $list->full_name = $l_user_details->first_name.' '.$l_user_details->last_name;
                    $list->account_id = $l_activationcode->account_id;
                    $list->package = $l_membership->membership_type_name;
                    $list->pv = $points_value;

                }

        }
        return view( $this->viewpath . 'index')
                ->with([
                    'lists' => $lists,
                    'pv_table'  => $pv_table
                    // 'right_lists' => $right_lists
                ]);
                
        
    }
    function postIndex(Request $request)
    {   

        if(!empty($request->input('account_id')) ) {
            return redirect('/admin/points-checker/index/'.$request->input('account_id'));
        }
    }
    // function exportMaintenanceHistory($type, $date_from, $date_to){
    //     $maintenance_teller = new ForMaintenance();
    //     $teller = $maintenance_teller->getMaintenance(); // get data

    //     $maintenance_deposit = new Withdrawals();
    //     $deposit = $maintenance_deposit->getMaintenance(); // get data

    //    if(empty($date_from) && empty($date_to)){
    //        $startDate = date("M d, Y", strtotime('first day of this month'));
    //        $endDate = date("M d, Y", strtotime('last day of this month'));

    //        $start_date_index = date("Y-m-d", strtotime($startDate)).' 00:00:01';
    //        $end_date_index = date("Y-m-d", strtotime($endDate)).' 23:59:59';

    //        $date_from = $start_date_index;
    //        $date_to = $end_date_index;
    //    }

    //   if(!empty($date_from)){
    //        $teller->where('for_maintenance.created_at', '>=', $date_from);
    //        $deposit->where('withdrawals.created_at', '>=', $date_from);
    //    }
    //    if(!empty($date_to)){
    //        $teller->where('for_maintenance.created_at', '<=', $date_to);
    //        $deposit->where('withdrawals.created_at', '<=', $date_to);
    //    }

    //    $t_details = $teller->get();
    //    $d_details = $deposit->get();

    //    $maintenance_details = [];
    //    $total_maintenance = 0;
    //    foreach ($t_details as $t) {
    //        $total_maintenance += $t->cbu;
    //        $maintenance_details[] = [
    //            'first_name' => $t->first_name,
    //            'last_name' => $t->last_name,
    //            'username' => $t->username,
    //            'account_id' => $t->account_id,
    //            'amount' => $t->cbu,
    //            'created_at' => $t->created_at->format("Y-m-d H:i:s"),
    //            'from' => 'Teller'
    //        ];
    //    }

    //    foreach ($d_details as $d) {
    //         $total_maintenance += $d->maintenance;
    //        $maintenance_details[] = [
    //            'first_name' => $d->first_name,
    //            'last_name' => $d->last_name,
    //            'username' => $d->username,
    //            'account_id' => $d->account_id,
    //            'amount' => $d->maintenance,
    //            'created_at' => $d->created_at->format("Y-m-d H:i:s"),
    //            'from'  => 'Deposit Account'
    //        ];
    //    }

    //    $maintenanceexcel = array(
    //         'maintenance_details' => $maintenance_details,
    //         'date_from'=>$date_from,
    //         'date_to'=>$date_to
    //     );

    //   return \Excel::create('Maintenance_Report', function($excel) use($maintenanceexcel) {

    //         $excel->sheet('Maintenance_Report', function($sheet) use(&$maintenanceexcel)
    //         {
    //             $sheet->loadView($this->viewpath . 'maintenance_excel' )
    //                 ->withMaintenanceexcel($maintenanceexcel);
    //         });

    //     })->download($type);
    // }
      
}
