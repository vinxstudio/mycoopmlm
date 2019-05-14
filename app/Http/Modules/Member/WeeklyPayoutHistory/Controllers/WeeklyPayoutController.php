<?php

/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 8:05 PM
 */

namespace App\Http\Modules\Member\WeeklyPayoutHistory\Controllers;

use App\Helpers\Binary;
use App\Http\AbstractHandlers\MemberAbstract;
use App\Models\User;
use App\Models\Earnings;
use App\Models\Accounts;
use App\Models\UserDetails;
use App\Models\ActivationCodes;
use App\Models\Membership;
use App\Models\ConvertGC;
use Illuminate\Http\Request;
use App\Http\TraitLayer\UserTrait;
use Response;
use Validator;
use App\Models\WeeklyPayout;

class WeeklyPayoutController extends MemberAbstract
{

    use UserTrait;
    protected $viewpath = 'Member.WeeklyPayoutHistory.views.';

    function __construct()
    {
        parent::__construct();
    }

    function getIndex(Request $request)
    {

        #get group_id
        $user = User::select('group_id', 'created_at')->where('id', $this->theUser->id)->first();
        $total_GI = 0;
        $total_NI = 0;
        $weekly_payout = new WeeklyPayout();
        $details = $weekly_payout->getWeeklyPayoutById($user->group_id);

        foreach ($details as $detail) {
            $total_GI += $detail->gross_income;
            $total_NI += $detail->net_income;
        }
        return view($this->viewpath . 'index')
            ->with([
                'weekly_payouts' => $details,
                'overall_total_GI' => $total_GI,
                'overall_total_NI' => $total_NI,
                'start_at' => $user->created_at
            ]);
    }

}
