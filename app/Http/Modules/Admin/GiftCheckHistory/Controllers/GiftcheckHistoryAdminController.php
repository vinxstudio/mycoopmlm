<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 8:05 PM
 */

namespace App\Http\Modules\Admin\GiftCheckHistory\Controllers;

use App\Helpers\Binary;
use App\Http\AbstractHandlers\AdminAbstract;
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

class GiftcheckHistoryAdminController extends AdminAbstract{

    use UserTrait;
    protected $viewpath = 'Admin.GiftCheckHistory.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex($date_from = null, $date_to = null){

        $date_from = (!empty($date_from))? $date_from : '';
        $date_to = (!empty($date_to))? $date_to : '';

        $convertGC = new ConvertGC;
        $gc = $convertGC->getGiftCheckHistory();

        if(!empty($date_from)) $gc->where('gc_convert.created_at', '>=', $date_from);
        if(!empty($date_to)) $gc->where('gc_convert.created_at', '<=', $date_to);
        $total_voucher = ConvertGC::all()->sum('voucher_value');
        $total_converted = ConvertGC::all()->sum('converted_voucher_value');

        $convert_gc = $convertGC->getConvertedGCDetails($gc->paginate(50));
        
        return view( $this->viewpath . 'index' )
                ->with([
                    'convert_gc' => $convert_gc,
                    'date_from' => $date_from,
                    'date_to' => $date_to,
                    'total_voucher' => (!empty($total_voucher)) ? $total_voucher : 0,
                    'total_converted' => (!empty($total_converted)) ? $total_converted : 0,
                ]);
     }

     function postIndex(Request $request)
     {
        if(!empty($request->input('date_range')) ) {
            return redirect('/admin/giftcheck-history/index/'.$request->input('date_from').'/'.$request->input('date_to'));
        }
     }

    function postValidateGc(Request $request)
    {   
        
        $validator = Validator::make($request->all(), [
            'validate_reason' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json(['errors' => "Reason field is required!"]);
        }
        
        $gc = ConvertGC::where('id', $request->gc_id)
                        ->update([
                            'status' => $request->input('status'),
                            'reason' => $request->input('validate_reason'),
                            'validated_by_id' => $request->input('validator_id')
                        ]);
        if($gc)
        {
            return response()->json(['message' => "Success!"]);
        }

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

    function exportGC($type, $date_from=null, $date_to=null ){
        $convertGC = new ConvertGC;
        $gc = $convertGC->getGiftCheckHistory();
        if(!empty($userIds)) $gc->whereIn('gc_convert.user_id', $userIds);

        if(!empty($date_from)) $gc->where('gc_convert.created_at', '>=', $date_from);
        if(!empty($date_to)) $gc->where('gc_convert.created_at', '<=', $date_to);
        
        $convert_gc = $convertGC->getConvertedGCDetails($gc->get());
     
        return \Excel::create('Giftcheck_history', function($excel) use($convert_gc) {

            $excel->sheet('Giftcheck_history', function($sheet) use(&$convert_gc)
            {
                $sheet->loadView($this->viewpath . 'giftcheck_history_excel' )
                    ->withConvert_gc($convert_gc);
            });

        })->download($type);
    }

}
