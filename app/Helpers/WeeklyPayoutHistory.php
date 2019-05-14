<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 10:44 AM
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

class WeeklyPayoutHistory{

    function __construct(){

    }

    function payout($params=array(), $date_from, $date_to){

        $payout = [];

        if($params){
            foreach($params as $earning){

                $user_group = DB::table('users')->where('group_id',$earning->group_id)->lists('id');

                $user_group_ids = $user_group;

                $QDR = DB::table('earnings')->where('source', 'direct_referral')
                                ->whereIn('user_id',$user_group_ids);

                if(!empty($date_from)){
                    $QDR->where('earnings.earned_date', '>=', $date_from);
                }

                if(!empty($date_to)){
                    $QDR->where('earnings.earned_date', '<=', $date_to);
                }

                $DRamount = $QDR->sum('amount');

                $QMB = DB::table('earnings')->where('source', 'pairing')
                                ->whereIn('user_id',$user_group_ids);

                if(!empty($date_from)){
                    $QMB->where('earnings.earned_date', '>=', $date_from);
                }

                if(!empty($date_to)){
                    $QMB->where('earnings.earned_date', '<=', $date_to);
                }

                $MBAmount = $QMB->sum('amount');

                $QDC = DB::table('earnings')->where('source', 'GC')
                                ->whereIn('user_id',$user_group_ids);

                if(!empty($date_from)){
                    $QDC->where('earnings.earned_date', '>=', $date_from);
                }

                if(!empty($date_to)){
                    $QDC->where('earnings.earned_date', '<=', $date_to);
                }
                $GC = $QDC->sum('amount');
                    

                if(!empty($membership) && $membership->entry_fee < 0) {
                    $total = $DRamount + $MBAmount;
                    $GC = 0;
                } else {
                    $total = $DRamount + $MBAmount;
                }
                
                if (!empty($membership) &&  $membership->entry_fee < 0) {
                    $totalpayout = ($total / 2);
                    $rb = $membership->entry_fee + ($total / 2);
                    if($rb > 0) {
                        $totalpayout = $totalpayout + $rb;
                        $rb = 0;    
                        
                    }
                }  else {
                    $totalpayout = $total;
                    $rb = 0;
                }

                    #get status 
                $weekly_payout = DB::table('weekly_approved_payout')->where('group_id',$earning->group_id)
                                    ->where('date_from',$date_from)
                                    ->where('date_to',$date_to)
                                    ->first();

                if($total != 0){
                    $payout[] = [
                        'fullname' => $earning->first_name.' '.$earning->last_name,
                        'dr' => $DRamount,
                        'mb' => $MBAmount,
                        'total' => $total,
                        'GC' => $GC,
                        'group_id' => $earning->group_id,
                        // 'acc_id'=>$earning->account_id,
                        'status'=> (!empty($weekly_payout->status))? $weekly_payout->status : 'Pending',
                        // 'user_id'=>$earning->user_id,
                        'id' => (!empty($weekly_payout->id))? $weekly_payout->id : '',
                        'package' => $earning->membership_type_name,
                        'date_from' => $date_from,
                        'date_to' => $date_to
                    ];
                }
            }

            $keys = array_column($payout, 'total');

            array_multisort($keys, SORT_DESC, $payout);
        }

        return $payout;
    }

}