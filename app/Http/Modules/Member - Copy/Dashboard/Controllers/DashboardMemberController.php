<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/4/17
 * Time: 6:29 PM
 */

namespace App\Http\Modules\Member\Dashboard\Controllers;

use App\Helpers\Binary;
use App\Helpers\ModelHelper;
use App\Helpers\UploadHelper;
use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\TraitLayer\BinaryTrait;
use App\Http\TraitLayer\UserTrait;
use App\Models\Membership;

use App\Models\Accounts;
use App\Models\CompanyBank;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;

class DashboardMemberController extends MemberAbstract{

    use UserTrait;

    protected $viewpath = 'Member.Dashboard.views.';
    protected $paypalSandbox = true;

    function __construct(){
        parent::__construct();
        $this->paypalSandbox = (config('paypal.sandbox') == TRUE_STATUS) ? true : false;
    }

    function getIndex(){

        if ($this->theUser->needs_activation == 'true'){
            return redirect('member/dashboard/activate-account');
        }
		$type = $this->theUser->type;
		//$member = Membership::find($type);
        return view( $this->viewpath . 'index' )->with(
                [
                    'membership'=>Membership::find($type)
                ]
        );
    }

    function getPayNow(){
        $uploaded = PaymentHistory::where([
            'user_id'=>$this->theUser->id,
           // 'amount'=>$this->theCompany->entry_fee,
		    'amount'=>$this->theMembership->entry_fee,
		   
            'status'=>PENDING_STATUS
        ])->get();
        return view( $this->viewpath . 'payment_methods' )
            ->with([
                'slip'=>($uploaded->isEmpty()) ? null : $uploaded->first(),
                'bank'=>CompanyBank::find(1)
            ]);
    }

    function postPayNow(Request $request){
        $error = false;
        $message = '';

        if ($request->hasFile('photo')){
            $file = $request->file('photo');
            $fileUpload = new UploadHelper();
            $fileResult = $fileUpload->upload($file);

            if (!$fileResult->error){
                $model = new ModelHelper();
                $model->manageModelData(new PaymentHistory, [
                    'user_id'=>$this->theUser->id,
                   // 'amount'=>$this->theCompany->entry_fee,
				   'amount'=>$this->theMembership->entry_fee,
                    'reference'=>null,
                    'object'=>null,
                    'file'=>$fileResult->path,
                    'payment_type'=>'bank-deposit',
                    'status'=>PENDING_STATUS,
                ]);
                $message = Lang::get('labels.deposit_uploaded');
            } else {
                $error = true;
                $message = $fileResult->message;
            }
        }

        return redirect('member/pay-now')->with([
            (($error) ? 'danger' : 'success')=>$message
        ]);
    }

    function getPaypalPayment(){
        $params = array(
            'cancelUrl' 	=> url('member/payment/failed'),
            'returnUrl' 	=> url('member/payment/done'),
            'name'		=> $this->theUser->details->fullName,
            'description' 	=> sprintf('%s ~ %s%s', Lang::get('labels.payment_description'), config('money.currency_symbol'), number_format($this->theCompany->entry_fee, 2)),
           // 'amount' 	=> round($this->theCompany->entry_fee, 2),
		   'amount'=> round($this->theMembership->entry_fee, 2),
            'currency' 	=> config('money.currency')
        );

        session(['paypalParameters'=>$params]);

        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(config('paypal.username'));
        $gateway->setPassword(config('paypal.password'));
        $gateway->setSignature(config('paypal.signature'));
        $gateway->setTestMode();

        $response = $gateway->purchase($params)->send(); //if no card

        if ($response->isSuccessful()) {
            //
        } elseif ($response->isRedirect()) {
            return redirect()->away($response->getRedirectUrl());
        } else {

            return redirect('member/payment/failed')->with([
                'danger'=>$response->getMessage()
            ]);
        }
    }

    function getFailed(Request $request){
        return view( $this->viewpath . 'failedPayment' );
    }

    function getDone(Request $request){
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(config('paypal.username'));
        $gateway->setPassword(config('paypal.password'));
        $gateway->setSignature(config('paypal.signature'));
        $gateway->setTestMode($this->paypalSandbox);

        $params = session('paypalParameters');
        $response = $gateway->completePurchase($params)->send();
        $paypalResponse = $response->getData();

        Session::forget('paypalParameters');
        if(isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {
            //record payment
            $model = new ModelHelper();
            $model->manageModelData(new PaymentHistory, [
                'user_id'=>$this->theUser->id,
                'amount'=>$paypalResponse['PAYMENTINFO_0_AMT'],
                'reference'=>$paypalResponse['PAYMENTINFO_0_TRANSACTIONID'],
                'object'=>serialize($paypalResponse),
                'status'=>APPROVED_STATUS,
                'payment_type'=>'paypal'
            ]);

            $this->theUser->needs_activation = 'true';
            $this->theUser->save();
            return redirect('member/dashboard/activate-account');

        } else {
            return redirect('member/payment/failed');

        }
    }

    function getActivateAccount(){
        return view( $this->viewpath . 'select_upline' )
            ->with([
                'uplineDropdown'=>$this->getAccountsDropdown($asUpline = true)
            ]);
    }

    function postActivateAccount(Request $request){
        $rules = [
            'upline'=>'required'
        ];

        $validate = Validator::make($request->input(), $rules);
        $error = false;

        if ($validate->fails()){
            $error = true;
        } else {
            $placement = $this->determinePlacement($request->upline);
            $activationCode = $this->generateActivationCode(1, $this->theUser->member_type_id);
            $model = new ModelHelper();
            $account = $model->manageModelData(new Accounts, [
                'user_id'=>$this->theUser->id,
                'code_id'=>$activationCode->id,
                'upline_id'=>$request->upline,
                'sponsor_id'=>DEFAULT_SPONSOR_ID,
                'node'=>$placement
            ]);
            $activationCode->status = USED_STATUS;
            $activationCode->paid_by_balance = FALSE_STATUS;
            $activationCode->save();
            $this->theUser->needs_activation = 'false';
            $this->theUser->paid = 'true';
            $this->theUser->save();
            $binary = new Binary();
            $pairing = $binary
                ->setMemberObject($account)
                ->crawl();

            $companyIncome = getRealCompanyIncome();
            $sponsor = Accounts::find(DEFAULT_SPONSOR_ID);
            $binary->runReferral($pairing, $companyIncome, DEFAULT_SPONSOR_ID, $sponsor, $activationCode,$this->theUser->id);

        }

        return ($error) ? redirect('member/dashboard/activate-account')
            ->withErrors($validate->errors()) : redirect('member/dashboard')
            ->with([
                'success'=>Lang::get('labels.account_activated')
            ]);
    }

    private function determinePlacement($uplineID){
        $accounts = Accounts::where([
            'upline_id'=>$uplineID
        ])->get();

        $alignment = LEFT_NODE;

        foreach ($accounts as $account){
            if ($account->node == LEFT_NODE){
                $alignment = RIGHT_NODE;
                break;
            }

            if ($account->node == RIGHT_NODE){
                $alignment = RIGHT_NODE;
                break;
            }
        }

        return $alignment;
    }

}