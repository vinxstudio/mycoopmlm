<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 8:05 PM
 */

namespace App\Http\Modules\Member\EncashmentSummary\Controllers;

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
use App\Models\EncashmentSummary;

class SummaryController extends MemberAbstract{

    use UserTrait;
    protected $viewpath = 'Member.EncashmentSummary.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(Request $request){
        $user = new User();
        $group_id = $user->groupId($this->theUser->id);
        $weekly_payout = new EncashmentSummary();
        $details = $weekly_payout->getEncashmentSummary($group_id);
        
        return view( $this->viewpath . 'index' )->with([
                        'summaries' => $details
                    ]);
                   
     }

}
