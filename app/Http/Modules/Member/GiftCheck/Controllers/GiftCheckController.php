<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 8:05 PM
 */

namespace App\Http\Modules\Member\GiftCheck\Controllers;

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

class GiftCheckController extends MemberAbstract{

    use UserTrait;
    protected $viewpath = 'Member.GiftCheck.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(Request $request){

        $earnings = new Earnings;
        $giftCheck = $earnings->getGiftCheck($this->theUser->userIds);
        return view( $this->viewpath . 'index' )
                    ->with([
                        'giftCheck' => $giftCheck,
                    ]);
     }

     function postIndex(Request $request)
     {
        // return response()->json($request->convert_type);
        $validator = Validator::make($request->all(), [
            'convert_type'  => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => "There's a problem in converting the voucher."]);
        }

        $val = explode("-", $request->convert_type);

        $convert = new ConvertGC();
        
        $convert->type = $val[0];
        $convert->converted_voucher_value = $val[1];
        $convert->earnings_id = $val[2];
        $convert->status = 'pending';
        $convert->user_id = $val[3];
        $convert->account_id = $val[4];
        $convert->voucher_value = $val[5];
        

        if ($convert->save()) {
            return response()->json(['message' => "Voucher Converted!"]);
        }

     }

     function getGiftCheckById($user_id)
     {
        
        $earnings = new Earnings;
        $giftCheck = $earnings->getGiftCheck($user_id);
        return view( $this->viewpath . 'index' )
                    ->with([
                        'giftCheck' => $giftCheck,
                    ]);
     }

     function getHistory()
     {
        $convertGC = new ConvertGC;
        $gc = $convertGC->getGiftCheckHistory($this->theUser->userIds);
        $gc->whereIn('gc_convert.user_id', $this->theUser->userIds);
        $convert_gc = $convertGC->getConvertedGCDetails($gc->paginate(50));
        return view( $this->viewpath . 'history' )->with(['convert_gc' => $convert_gc]);
        
     }

     function getReason($id)
    {   
        $reason = ConvertGC::select('gc_convert.reason','gc_convert.updated_at','gc_convert.status', 'user_details.first_name', 'user_details.last_name')
                            ->leftJoin('user_details', 'user_details.id', '=', 'gc_convert.validated_by_id')
                            ->where('gc_convert.id', $id)->first();
        $fullName = $reason->first_name.' '.$reason->last_name;
        $date = date('d-m-Y', strtotime($reason->updated_at));
        if($reason)
        {
            return response()->json([
                'fullName' => $fullName,
                'reason' => $reason->reason,
                'updated_at' => $date,
                'status' => $reason->status
            ]);
        }
    }
}
