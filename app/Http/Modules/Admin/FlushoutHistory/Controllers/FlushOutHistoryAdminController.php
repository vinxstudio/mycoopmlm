<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 8:05 PM
 */

namespace App\Http\Modules\Admin\FlushOutHistory\Controllers;

// use App\Helpers\Binary;
use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\User;
// use App\Models\Earnings;
use App\Models\Accounts;
use App\Models\UserDetails;
use App\Models\ActivationCodes;
use App\Models\Membership;
use App\Models\ConvertGC;
use App\Models\Flushout;
use App\Models\Earnings;
use App\Models\Details;
use Illuminate\Http\Request;
use App\Http\TraitLayer\UserTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Response;
use Validator;

class FlushOutHistoryAdminController extends AdminAbstract{

    use UserTrait;
    protected $viewpath = 'Admin.FlushoutHistory.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex($date_from = null, $date_to = null){

        $date_from = (!empty($date_from))? $date_from : '';
        $date_to = (!empty($date_to))? $date_to : '';

        $overall_total = Earnings::select('amount')
                        ->where('source', 'flushout')
                        ->where('amount', '!=', 1)
                        ->sum('amount');

        // $q = Flushout::select('amount')->whereIn('source', ['pairing']);
        // if(!empty($date_from)) $q->where('flushout.created_at', '>=', $date_from);
        // if(!empty($date_to)) $q->where('flushout.created_at', '<=', $date_to);
        // $flushout_total = $q->sum('amount');

        $earnings_model = new Earnings;
        $flushout = $earnings_model->getFlushout();

        if(!empty($date_from)) $flushout->where('earnings.earned_date', '>=', $date_from);
        if(!empty($date_to)) $flushout->where('earnings.earned_date', '<=', $date_to);

        $flushout_list = $flushout->paginate(50);
        
        return view( $this->viewpath . 'index' )
                ->with([
                    'overall_total' => $overall_total,
                    'flushout_list' => $flushout_list,
                    'flushout_total' => (!empty($flushout_total)) ? $flushout_total : 0,
                    'date_from' => $date_from,
                    'date_to' => $date_to
                ]);
     }

     function postIndex(Request $request)
     {
        if(!empty($request->input('date_range')) ) {
            return redirect('/admin/flushout-history/index/'.$request->input('date_from').'/'.$request->input('date_to'));
        }
     }

    function getDetails(Request $request, $id, $date_from = null, $date_to = null)
    {
        $date_from = (!empty($date_from))? $date_from : '';
        $date_to = (!empty($date_to))? $date_to : '';

        $overall_total = Earnings::select('amount')
                        ->where('source', 'flushout')
                        ->where('account_id', $id)
                        ->where('amount', '!=', 1)
                        ->sum('amount');

        $earnings_model = new Earnings;
        $flushout = $earnings_model->getFlushoutDetails($id, $date_from, $date_to);
        // $overall_total = $earnings_model->getFlushoutTotalAmount($id, $date_from, $date_to);

        $user_account = Accounts::find($id);
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
    
        // $earnings_model = new Earnings;
        // $flushout = $earnings_model->getFlushoutDetails($id, $date_from, $date_to);

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $itemCollection = collect($flushout);
 
        // Define how many items we want to be visible in each page
        $perPage = 50;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($flushout), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());

        return view( $this->viewpath . 'flushout_details' )
                ->with([
                    'overall_total' => $overall_total,
                    'flushout_list' => $paginatedItems,
                    'user_info' => $user_info,
                    'account_id' => $id,
                    'date_from' => $date_from,
                    'date_to' => $date_to
                ]);
    }

    function postDetails(Request $request)
    {
       if(!empty($request->input('date_range')) ) {
           return redirect('/admin/flushout-history/details/'.$request->input('account_id').'/'.$request->input('date_from').'/'.$request->input('date_to'));
       }
    }

    function exportFlushoutDetails($type, $id, $date_from = null, $date_to = null)
    {
        
        $date_from = (!empty($date_from))? $date_from : '';
        $date_to = (!empty($date_to))? $date_to : '';

        // $overall_total = Earnings::select('amount')
        //                 ->where('source', 'flushout')
        //                 ->where('account_id', $id)
        //                 ->sum('amount');

        $earnings_model = new Earnings();
        $flushout = $earnings_model->getFlushoutDetails($id, $date_from, $date_to);

        $overall_total = $earnings_model->getFlushoutTotalAmount($id, $date_from, $date_to);

        $f_account = Accounts::find($id);
        $f_user = User::find($f_account->user_id);
        $f_user_details = Details::find($f_user->user_details_id);
        $f_membership = Membership::find($f_user->member_type_id);
        $f_activationcode = ActivationCodes::where('user_id',$f_user->id)->first();

        $owner = [
            'owner_account_id' => (!empty($f_activationcode))?$f_activationcode->account_id:'',
            'owner_name' => $f_user_details->first_name.' '.$f_user_details->last_name,
            'owner_package' => $f_membership->membership_type_name,
            'owner_account_date' =>$f_account->created_at,
        ];
        
        $flushoutexcel = array(
            'flushout_details' => $flushout,
            'owner'=>$owner,
            'overall_total' => $overall_total,
        );

        return \Excel::create('Flushout_Report_'.$owner['owner_account_id'], function($excel) use($flushoutexcel) {

            $excel->sheet('Flushout_Report', function($sheet) use(&$flushoutexcel)
            {
                $sheet->loadView($this->viewpath . 'flushout_details_excel' )
                    ->withFlushoutexcel($flushoutexcel);
            });

        })->download($type);
   
    }

    

    function exportFlushout($type, $date_from=null, $date_to=null ){
        $flushout_model = new Flushout;
        $flushout = $flushout_model->getFlushout();

        if(!empty($date_from)) $flushout->where('flushout.created_at', '>=', $date_from);
        if(!empty($date_to)) $flushout->where('flushout.created_at', '<=', $date_to);
        
        $flushout_list = $flushout->get();
     
        return \Excel::create('Flushout_Report', function($excel) use($flushout_list) {

            $excel->sheet('Flushout_Report', function($sheet) use(&$flushout_list)
            {
                $sheet->loadView($this->viewpath . 'flushout_history_excel' )
                    ->withFlushout_list($flushout_list);
            });

        })->download($type);
    }

    

}
