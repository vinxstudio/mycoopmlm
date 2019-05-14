<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/4/17
 * Time: 6:20 PM
 */

namespace App\Http\Modules\Admin\Withdrawals\Controllers;

use App\Helpers\MailHelper;
use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class WithdrawalsAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.Withdrawals.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        $q = Withdrawals::orderBy('id', 'desc');
        
        $withdrawals = $q->paginate($this->records_per_page);
        return view( $this->viewpath . 'index' )
            ->with([
                'withdrawals'=>$withdrawals,
                'date_from'=>'',
                'date_to'=>''
            ]);

    }

    function postIndex(Request $request){

        $date_from = ($request->date_from)? $request->date_from : '';
        $date_to = ($request->date_to)? $request->date_to : '';

        $q = Withdrawals::orderBy('id', 'desc');

        if(!empty($date_from)){
            $q->where('created_at', '>=', $date_from);
        }
  
        if(!empty($date_to)){
            $q->where('created_at', '<=', $date_to);
        }
        
        $withdrawals = $q->paginate($this->records_per_page);

        return view( $this->viewpath . 'index' )
            ->with([
                'withdrawals'=>$withdrawals,
                'date_from'=>$date_from,
                'date_to'=>$date_to
            ]);

    }

    function getCancelRequest($id){
        $withdraw = Withdrawals::find($id);

        if (isset($withdraw->id)) {
            $withdraw->status = DENIED_STATUS;
            $withdraw->save();

            if ($withdraw->user->details->email != null and isEmailRequired()){
                $mail = new MailHelper();
                $mail->setUserObject($withdraw->user)
                    ->setWithdrawalObject($withdraw)
                    ->sendMail(WITHDRAWAL_KEY);
            }
        }

        return back()->with('success', Lang::get('withdrawal.success_deny'));;
    }

    function getApproveRequest($id)
    {
        $withdraw = Withdrawals::find($id);

        if (isset($withdraw->id)) {
            $withdraw->status = APPROVED_STATUS;
            $withdraw->save();

            if ($withdraw->user->details->email != null and isEmailRequired()){
                $mail = new MailHelper();
                $mail->setUserObject($withdraw->user)
                    ->setWithdrawalObject($withdraw)
                    ->sendMail(WITHDRAWAL_KEY);
            }
        }

        return back()->with('success', Lang::get('withdrawal.success_approved'));;
    }

    function downloadWithdrawals($file_type, $from, $to){
        // echo $date_from.' to '.$date_to;
        $date_from = ($from)? $from : '';
        $date_to = ($to)? $to : '';
        
        $q = Withdrawals::orderBy('id', 'desc');

        if(!empty($date_from)){
            $q->where('created_at', '>=', $date_from);
        }
  
        if(!empty($date_to)){
            $q->where('created_at', '<=', $date_to);
        }
        
        $withdrawals = $q->get();

        $requestedlist = array(
                'withdrawals'=>$withdrawals,
                'date_from'=>$from,
                'date_to'=>$to
                );

        return \Excel::create( 'Request Withdrawal Report' , function($excel) use($requestedlist) {

                $excel->sheet( 'Request Withdrawal Report' , function($sheet) use(&$requestedlist)
                {
                    $sheet->loadView($this->viewpath . 'request_withdrawal_report' )
                        ->withrequestedlist($requestedlist);
                });

            })->download($file_type);
    }

}