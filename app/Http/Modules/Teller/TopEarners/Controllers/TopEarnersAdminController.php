<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 5/31/17
 * Time: 7:27 PM
 */

namespace App\Http\Modules\Admin\TopEarners\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Earnings;
use App\Models\User;

class TopEarnersAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.TopEarners.views.';
    protected $getTop = 5;

    function getIndex($monthYear = ALL_TIME_KEY){

        $grouped = Earnings::where('amount', '>', 0)->where('source', '!=', GC_EARNINGS);

        if ($monthYear == ALL_TIME_KEY){

        }

        $result = $grouped->get();

        $data = [];

        foreach ($result as $earned){
            if (!isset($data[$earned->user_id])){
                $data[$earned->user_id] = 0;
            }

            $data[$earned->user_id] += $earned->amount;
        }

        asort($data);
        $totalArray = count($data) - 1;
        $keys = array_keys($data);
        $topUsers = [];
        $count = $this->getTop;
        $sortedData = [];
        $userData = [];
        while ($count > 0){
            if (isset($keys[$totalArray])) {
                $topUsers[] = $keys[$totalArray];
                $sortedData[$keys[$totalArray]] = $data[$keys[$totalArray]];
                $totalArray--;
                $count--;
            } else {
                break;
            }
        }

        $users = User::whereIn('id', $topUsers)->get();

        foreach($users as $user){
            $userData[$user->id] = $user;
        }

        $dates[ALL_TIME_KEY] = ALL_TIME_KEY;
        $dates = $this->getEarningsDates();

        return view( $this->viewpath . 'index' )
            ->with([
                'dates'=>$dates,
                'data'=>$sortedData,
                'users'=>$userData
            ]);
    }

}