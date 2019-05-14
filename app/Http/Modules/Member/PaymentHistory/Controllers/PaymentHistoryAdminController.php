<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 11:26 AM
 */

namespace App\Http\Modules\Admin\PaymentHistory\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\PaymentHistory;
use App\Models\User;
use Illuminate\Support\Facades\Lang;

class PaymentHistoryAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.PaymentHistory.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        $payments = PaymentHistory::orderBy('status', 'DESC')->orderBy('created_at', 'DESC')->get();
        return view( $this->viewpath . 'index' )
            ->with([
                'payments'=>$payments
            ]);
    }

    function getAction($action, $paymentID){
        $actionLabel = ($action == 'approve') ? APPROVED_STATUS : DENIED_STATUS;

        PaymentHistory::where([
            'id'=>$paymentID
        ])->update([
            'status'=>($action == 'approve') ? 'approved' : 'denied'
        ]);

        if ($action == 'approve') {
            $payment = PaymentHistory::find($paymentID);
            $user = User::find($payment->user_id);
            $user->needs_activation = TRUE_STATUS;
            $user->save();
        }

        return redirect('admin/payment-history')->with([
            'success'=>sprintf('%s %s', Lang::get('labels.payment_status_changed'), $actionLabel)
        ]);
    }

}