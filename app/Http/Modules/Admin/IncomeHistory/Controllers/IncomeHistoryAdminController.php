<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 11:26 AM
 */

namespace App\Http\Modules\Admin\IncomeHistory\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\ActivationCodes;
use App\Models\ActivationCodeBatches;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Details;
use Illuminate\Support\Facades\Lang;

class IncomeHistoryAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.IncomeHistory.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
       
        return view( $this->viewpath . 'index' )
            ->with([
                'payments'=>$this->listPayment(),
                'date_from'=>'',
                'date_to'=>''
            ]);
    }

    function postIndex(Request $request){

        $date_from = (!empty($request->input('date_from')))? $request->input('date_from') : '';
        $date_to = (!empty($request->input('date_to')))?$request->input('date_to') : '';


        return view( $this->viewpath . 'index' )
            ->with([
                'payments'=>$this->listPayment($date_from, $date_to),
                'date_from'=>$date_from,
                'date_to'=>$date_to
            ]);
    }
    function getAction($action, $paymentID){
        $actionLabel = ($action == 'approve') ? APPROVED_STATUS : DENIED_STATUS;

        ActivationCodes::where([
            'id'=>$paymentID
        ])->update([
            'status'=>($action == 'approve') ? 'approved' : 'denied'
        ]);

        if ($action == 'approve') {
            $payment = CompanyEarnings::find($paymentID);
            $user = User::find($payment->user_id);
            $user->needs_activation = TRUE_STATUS;
            $user->save();
        }

        return redirect('admin/income-history')->with([
            'success'=>sprintf('%s %s', Lang::get('labels.payment_status_changed'), $actionLabel)
        ]);
    }

    public function listPayment($date_from=null, $date_to=null)
    {
        $payments =  ActivationCodes::select('activation_code_batches.name','activation_codes.account_id','activation_codes.code','users.username','user_details.first_name','user_details.last_name','activation_codes.type','membership_settings.entry_fee','activation_codes.created_at','t.username as t_username','ut.first_name as t_fname','ut.last_name as t_lname', 'b.name as bname')
            ->join('users','users.id','=','activation_codes.user_id')
            ->leftJoin('users as t','t.id','=','activation_codes.teller_id')
            ->leftJoin('user_details as ut','ut.id','=','t.user_details_id')
            ->leftJoin('branches as b','b.id','=','t.branch_id')
            ->join('activation_code_batches','activation_codes.batch_id','=','activation_code_batches.id')
            ->join('user_details','user_details.id','=','users.user_details_id')
            ->join('membership_settings','membership_settings.id','=','users.member_type_id')
            ->where('activation_codes.status', 'used')
            ->orderBy('activation_codes.created_at', 'DESC')
            ->groupBy('activation_codes.user_id');

        if(!empty($date_from)){
            $payments->where('activation_codes.created_at', '>=', $date_from);
        }

        if(!empty($date_to)){
            $payments->where('activation_codes.created_at', '<=', $date_to);
        }

        $return = $payments->get();

        return $return;
    }

    public function exportRegistrationHistory($file_type, $from, $to){

        $date_from = (!empty($from))?  date('Y-m-d H:i:s', strtotime($from)) : '';
        $date_to = (!empty($to))? date('Y-m-d H:i:s', strtotime($to)) : '';

        $payments =  ActivationCodes::select('activation_code_batches.name','activation_codes.account_id','activation_codes.code','users.username','user_details.first_name','user_details.last_name','activation_codes.type','membership_settings.entry_fee','activation_codes.created_at','t.username as t_username','ut.first_name as t_fname','ut.last_name as t_lname', 'b.name as bname')
            ->join('users','users.id','=','activation_codes.user_id')
            ->leftJoin('users as t','t.id','=','activation_codes.teller_id')
            ->leftJoin('user_details as ut','ut.id','=','t.user_details_id')
            ->leftJoin('branches as b','b.id','=','t.branch_id')
            ->join('activation_code_batches','activation_codes.batch_id','=','activation_code_batches.id')
            ->join('user_details','user_details.id','=','users.user_details_id')
            ->join('membership_settings','membership_settings.id','=','users.member_type_id')
            ->where('activation_codes.status', 'used')
            ->orderBy('activation_codes.created_at', 'DESC')
            ->groupBy('activation_codes.user_id');

        if(!empty($date_from)){
            $payments->where('activation_codes.created_at', '>=', $date_from);
        }

        if(!empty($date_to)){
            $payments->where('activation_codes.created_at', '<=', $date_to);
        }

        $return = $payments->get();

        $registration = array(
            'payments'=>$return,
            'date_from'=>$date_from,
            'date_to'=>$date_to
            );
    
        return \Excel::create( 'Registration_History' , function($excel) use($registration) {

            $excel->sheet( 'Registration_History' , function($sheet) use(&$registration)
            {
                $sheet->loadView($this->viewpath . 'registration_history_excel' )
                    ->withregistration($registration);
            });

        })->download($file_type);
    }

}
