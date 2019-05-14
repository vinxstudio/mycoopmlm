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

use App\Models\UserDetails;
use App\Models\Accounts;
use App\Models\User;
use App\Models\Earnings;
use App\Models\ConvertGC;
use App\Models\ActivationCodes;
use App\Models\ProductIncentives;
use App\Models\CompanyBank;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Omnipay\Omnipay;
use App\Models\UserNetwork;

class DashboardMemberController extends MemberAbstract
{

    use UserTrait;

    protected $viewpath = 'Member.Dashboard.views.';
    protected $paypalSandbox = true;

    function __construct()
    {
        parent::__construct();
        $this->paypalSandbox = (config('paypal.sandbox') == TRUE_STATUS) ? true : false;
    }

    function getIndex()
    {

        // if ($this->theUser->needs_activation == 'true') {
        //     return redirect('member/dashboard/activate-account');
        // }

        $account_summary = $this->accountSummary($this->theUser->userIds);

        $start_date = '2018-05-26 00:00:01';
        $curr_date = date('Y-m-d H:i:s');
        $end_range = (date("l", strtotime($curr_date)) == 'Saturday') ? -1 : 1;
        $announcement = DB::table('announcement')
            ->where([
                'status' => 1,
                'delete' => 0,
            ])
            ->where('display_date', '<=', date('Y-m-d'))
            ->orderBy('display_date', 'DESC')
            ->orderBy('announcement.created_at', 'DESC')
            ->get();

        // $available_balance = $this->calPayout(2, $end_range, $this->theUser->userIds, $start_date);

        $data = $this->calPayout(-1, 1, $this->theUser->userIds);
        $data['account_summary'] = $account_summary['account_summary'];
        $data['t_dr'] = $account_summary['t_dr'];
        $data['t_mb'] = $account_summary['t_mb'];
        $data['t_gc'] = $account_summary['t_gc'];
        $data['total_value_gc'] = $account_summary['total_value_gc'];
        $data['available_balance'] = $this->theUser->remainingBalance;
        $data['announcement'] = $announcement;
        $data['coop_id'] = $this->theUser->id;

        /**
         * Sponsor - Request
         */
        $user_network = new UserNetwork();
        $user_id = auth()->user()->id;

        $sponsor_request = $user_network->request_member($user_id, $user_network::STATUS_PENDING);

        return view($this->viewpath . 'index')->with($data)->with([
            'sponsor_request' => $sponsor_request
        ]);
    }

    function postIndex(Request $request)
    {
        if (!empty($request->input('prev'))) {
            $start = $request->input('start');
            $end = $request->input('end');
        } else {
            $start = $request->input('start');
            $end = $request->input('end');
        }

        $announcement = DB::table('announcement')
            ->where([
                'status' => 1,
                'delete' => 0,
            ])
            ->where('display_date', '<=', date('Y-m-d'))
            ->orderBy('display_date', 'DESC')
            ->orderBy('announcement.created_at', 'DESC')
            ->get();

        // $available_balance = $this->availableBalance($start, $end);

        $account_summary = $this->accountSummary($this->theUser->userIds);

        $start_date = '2018-05-26 00:00:01';
        $curr_date = date('Y-m-d H:i:s');
        $end_range = (date("l", strtotime($curr_date)) == 'Saturday') ? -1 : 1;

        $available_balance = $this->calPayout(2, $end_range, $this->theUser->userIds, $start_date);

        $data = $this->calPayout($start, $end, $this->theUser->userIds);
        $data['account_summary'] = $account_summary['account_summary'];
        $data['t_dr'] = $account_summary['t_dr'];
        $data['t_mb'] = $account_summary['t_mb'];
        $data['t_gc'] = $account_summary['t_gc'];
        $data['total_value_gc'] = $account_summary['total_value_gc'];
        $data['available_balance'] = $this->theUser->remainingBalance;
        $data['announcement'] = $announcement;

        return view($this->viewpath . 'index')->with($data);
    }

    function accountSummary($user_group_ids)
    {
        $myAccounts = array();
        $user_ids = array();

        $total_DR = 0;
        $total_MB = 0;
        $total_GC = 0;
        $total_value_gc = 0;

        $earnings = new Earnings;
        $total_value_gc = $earnings->getTotalGC($user_group_ids);
        
        foreach ($user_group_ids as $user_id) {
            $user_ids[] = $user_id;

            $countLPV = Earnings::where([
                'user_id' => $user_id,
                'source' => 'left_pv'
            ])->sum('amount');
            $countRPV = Earnings::where([
                'user_id' => $user_id,
                'source' => 'right_pv'
            ])->sum('amount');
            if ($countRPV < 0) {
                $countRPV = abs($countRPV);
            }
            if ($countLPV < 0) {
                $countLPV = abs($countLPV);
            }

            // get account 
            $accounts = Accounts::where('user_id', $user_id)->first();
            $user = User::where('id', $user_id)->first();


            $TotalDRI = Earnings::where('user_id', $user_id)
                ->where('source', 'direct_referral')
                ->sum('amount');

            $TotalGC = Earnings::where('user_id', $user_id)
                ->where('source', 'GC')
                ->sum('amount');

            $TotalMSBI = Earnings::where('user_id', $user_id)
                ->where('source', 'pairing')
                ->sum('amount');


            $Totalearnings = $TotalDRI + $TotalMSBI;
            $account_id = (!empty($accounts->id)) ? $accounts->id : 0;
            $myAccounts[] = array(
                'username' => $user->username,
                'acc_id' => $account_id,
                'DRI' => $TotalDRI,
                'MSBI' => $TotalMSBI,
                'GC' => $TotalGC,
                'GI' => $Totalearnings,
                'lpv' => $countLPV,
                'rpv' => $countRPV,
                'total_value_gc' => $total_value_gc
            );
            $total_DR = $total_DR + $TotalDRI;
            $total_MB = $total_MB + $TotalMSBI;
            $total_GC = $total_GC + $TotalGC;
        }
        $data = array(
            'account_summary' => $myAccounts,
            'user_ids' => $user_ids,
            't_dr' => $total_DR,
            't_mb' => $total_MB,
            't_gc' => $total_GC,
            'total_value_gc' => $total_value_gc
        );

        return $data;
    }

    function availableBalance($start, $end)
    {
        $startDate = date("m/d/y", strtotime(date("w") ? $start . " saturdays ago" : " last saturday"));
        $endDate = date("m/d/y", strtotime(date("w") ? $end . " saturdays ago" : " last saturday"));

        $date_from = date('04-28-2018 12:01 00:01:00');
        $date_to = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));

        #get all my account id
        $details = $this->theUser->details()->first();

        $myAccounts = array();
        $user_ids = array();

        $total_DR = 0;
        $total_MB = 0;
        $total_GC = 0;

        foreach ($this->theUser->userIds as $user_id) {
            $user_ids[] = $user_id;

            // get account 
            $accounts = Accounts::where('user_id', $user_id)->first();
            $user = User::where('id', $user_id)->first();
            $TotalDRI = Earnings::where('user_id', $user_id)
                ->where('source', 'direct_referral')
                ->whereBetween('earned_date', [$date_from, $date_to])
                ->sum('amount');

            $TotalGC = Earnings::where('user_id', $user_id)
                ->where('source', 'GC')
                ->sum('amount');

            $TotalMSBI = Earnings::where('user_id', $user_id)
                ->whereBetween('earned_date', [$date_from, $date_to])
                ->where('source', 'pairing')
                ->sum('amount');

            $Totalearnings = $TotalDRI + $TotalMSBI;
            $account_id = (!empty($accounts->id)) ? $accounts->id : 0;
            $myAccounts[] = array(
                'username' => $user->username,
                'acc_id' => $account_id,
                'DRI' => $TotalDRI,
                'MSBI' => $TotalMSBI,
                'GC' => $TotalGC,
                'GI' => $Totalearnings,

            );
            $total_DR = $total_DR + $TotalDRI;
            $total_MB = $total_MB + $TotalMSBI;
            $total_GC = $total_GC + $TotalGC;
        }
        $data = array(
            'available_balance' => $total_GC,
        );

        return $data;
    }

    function calPayout($start, $end, $user_ids, $start_date = null)
    {

        $type = $this->theUser->type;
        // die('sdfsd='.$this->theUser->id);
        $date = date('Y-m-d H:i:s');
        $MyGivenDateIn = strtotime($date);
        $ConverDate = date("l", $MyGivenDateIn);
        $ConverDateTomatch = strtolower($ConverDate);
        if (($ConverDateTomatch == "saturday")) {
            $startDate = date("m/d/y", strtotime(" saturday"));
            $endDate = date("m/d/y", strtotime("2 saturday"));
        } else {
            $startDate = date("m/d/y", strtotime($start . " saturday"));
            $endDate = date("m/d/y", strtotime($end . " saturday"));
        }



        // $startDate = date("m/d/y", strtotime(  $start." saturday"));
        // $endDate = date("m/d/y", strtotime( $end." saturday"));

        $date_from = date('Y-m-d H:i:s', strtotime($startDate . ' 06:00:01'));
        $date_to = date('Y-m-d H:i:s', strtotime($endDate . ' 05:59:59'));

        if (!empty($start_date)) {
            $date_from = $start_date;
            // pr($date_from.' - '.$date_to);
        }

        $TotalDRI = Earnings::whereIn('user_id', $user_ids)
            ->whereBetween('created_at', [$date_from, $date_to])
            ->where('source', 'direct_referral')
            ->sum('amount');

        $TotalGC = Earnings::whereIn('user_id', $user_ids)
            ->whereBetween('created_at', [$date_from, $date_to])
            ->where('source', 'GC')
            ->sum('amount');

        $TotalPair = Earnings::whereIn('user_id', $user_ids)
            ->whereBetween('created_at', [$date_from, $date_to])
            ->where('source', 'pairing')
            ->count();

        $TotalMSBI = Earnings::whereIn('user_id', $user_ids)
            ->whereBetween('created_at', [$date_from, $date_to])
            ->where('source', 'pairing')
            ->sum('amount');

        $totalUniLvl = ProductIncentives::leftJoin('accounts', 'accounts.id', '=', 'product_incentive.sponsor_id')
            ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
            ->whereIn('users.id', $user_ids)
            ->whereBetween('product_incentive.created_at', [$date_from, $date_to])
            ->sum('product_incentive.amount');


        $Totalearnings = $TotalDRI + $TotalMSBI;
        // $activation = ActivationCodes::whereIn('user_id', $user_ids)->first();

        /*if (isset($activation->type_id) && $activation->type_id > 3) {
            $Totalearnings = 0;
            $TotalGC = 0;
            $TotalMSBI = 0;
            $TotalDRI = 0;
        }*/

        return [
            'membership' => Membership::find($type),
            'DRI' => $TotalDRI,
            'MSBI' => $TotalMSBI,
            'GC' => $TotalGC,
            'NMSBI' => $TotalPair,
            'GI' => $Totalearnings,
            'unilevel' => $totalUniLvl,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'start' => $start,
            'end' => $end,

        ];
    }

    function getPayNow()
    {
        $uploaded = PaymentHistory::where([
            'user_id' => $this->theUser->id,
            // 'amount'=>$this->theCompany->entry_fee,
            'amount' => $this->theMembership->entry_fee,

            'status' => PENDING_STATUS
        ])->get();
        return view($this->viewpath . 'payment_methods')
            ->with([
                'slip' => ($uploaded->isEmpty()) ? null : $uploaded->first(),
                'bank' => CompanyBank::find(1)
            ]);
    }

    function postPayNow(Request $request)
    {
        $error = false;
        $message = '';

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileUpload = new UploadHelper();
            $fileResult = $fileUpload->upload($file);

            if (!$fileResult->error) {
                $model = new ModelHelper();
                $model->manageModelData(new PaymentHistory, [
                    'user_id' => $this->theUser->id,
                    // 'amount'=>$this->theCompany->entry_fee,
                    'amount' => $this->theMembership->entry_fee,
                    'reference' => null,
                    'object' => null,
                    'file' => $fileResult->path,
                    'payment_type' => 'bank-deposit',
                    'status' => PENDING_STATUS,
                ]);
                $message = Lang::get('labels.deposit_uploaded');
            } else {
                $error = true;
                $message = $fileResult->message;
            }
        }

        return redirect('member/pay-now')->with([
            (($error) ? 'danger' : 'success') => $message
        ]);
    }

    function getPaypalPayment()
    {
        $params = array(
            'cancelUrl' => url('member/payment/failed'),
            'returnUrl' => url('member/payment/done'),
            'name' => $this->theUser->details->fullName,
            'description' => sprintf('%s ~ %s%s', Lang::get('labels.payment_description'), config('money.currency_symbol'), number_format($this->theCompany->entry_fee, 2)),
            // 'amount' 	=> round($this->theCompany->entry_fee, 2),
            'amount' => round($this->theMembership->entry_fee, 2),
            'currency' => config('money.currency')
        );

        session(['paypalParameters' => $params]);

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
                'danger' => $response->getMessage()
            ]);
        }
    }

    function getFailed(Request $request)
    {
        return view($this->viewpath . 'failedPayment');
    }

    function getDone(Request $request)
    {
        $gateway = Omnipay::create('PayPal_Express');
        $gateway->setUsername(config('paypal.username'));
        $gateway->setPassword(config('paypal.password'));
        $gateway->setSignature(config('paypal.signature'));
        $gateway->setTestMode($this->paypalSandbox);

        $params = session('paypalParameters');
        $response = $gateway->completePurchase($params)->send();
        $paypalResponse = $response->getData();

        Session::forget('paypalParameters');
        if (isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {
            //record payment
            $model = new ModelHelper();
            $model->manageModelData(new PaymentHistory, [
                'user_id' => $this->theUser->id,
                'amount' => $paypalResponse['PAYMENTINFO_0_AMT'],
                'reference' => $paypalResponse['PAYMENTINFO_0_TRANSACTIONID'],
                'object' => serialize($paypalResponse),
                'status' => APPROVED_STATUS,
                'payment_type' => 'paypal'
            ]);

            $this->theUser->needs_activation = 'true';
            $this->theUser->save();
            return redirect('member/dashboard/activate-account');
        } else {
            return redirect('member/payment/failed');
        }
    }

    function getActivateAccount()
    {
        return view($this->viewpath . 'select_upline')
            ->with([
                'uplineDropdown' => $this->getAccountsDropdown($asUpline = true)
            ]);
    }

    function postActivateAccount(Request $request)
    {
        $rules = [
            'upline' => 'required'
        ];

        $validate = Validator::make($request->input(), $rules);
        $error = false;

        if ($validate->fails()) {
            $error = true;
        } else {
            $placement = $this->determinePlacement($request->upline);
            $activationCode = $this->generateActivationCode(1, $this->theUser->member_type_id);
            $model = new ModelHelper();
            $account = $model->manageModelData(new Accounts, [
                'user_id' => $this->theUser->id,
                'code_id' => $activationCode->id,
                'upline_id' => $request->upline,
                'sponsor_id' => DEFAULT_SPONSOR_ID,
                'node' => $placement
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
            $binary->runReferral($pairing, $companyIncome, DEFAULT_SPONSOR_ID, $sponsor, $activationCode, $this->theUser->id);
        }

        return ($error) ? redirect('member/dashboard/activate-account')
            ->withErrors($validate->errors()) : redirect('member/dashboard')
            ->with([
                'success' => Lang::get('labels.account_activated')
            ]);
    }

    private function determinePlacement($uplineID)
    {
        $accounts = Accounts::where([
            'upline_id' => $uplineID
        ])->get();

        $alignment = LEFT_NODE;

        foreach ($accounts as $account) {
            if ($account->node == LEFT_NODE) {
                $alignment = RIGHT_NODE;
                break;
            }

            if ($account->node == RIGHT_NODE) {
                $alignment = RIGHT_NODE;
                break;
            }
        }

        return $alignment;
    }

    function postLogin(Request $request)
    {
        $id = $request->input('goto_user_id');

        if ($id) {
            Auth::logout();
            Session::flush();
            Auth::loginUsingId($id);
            $role = Auth::user()->role;
            return redirect($role . '/dashboard');
        } else {
            return redirect('member/dashboard');
        }
    }

    function postCoopId(Request $request)
    {

        $details = UserDetails::find($request->id);
        $details->coop_id = $request->coop_id;

        if ($details->save()) {
            return response()->json(['message' => 'Successfully Updated Coop ID.']);
        }

        return response()->json(['error' => 'Something went wrong!']);
    }


    function getFlushOut()
    {
        try {
            $binary = new Binary();
            $binary->flushout();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * accept request member
     */

    function postRequestStatus(Request $request)
    {

        $network_id = $request->network_id;
        $new_status = $request->status;

        if ($new_status == 1)
            $new_status = UserNetwork::STATUS_SPONSOR_APPROVED;
        else if ($new_status == -1)
            $new_status = UserNetwork::STATUS_SPONSOR_DISAPPROVED;

        $data = [];
        $data['status'] = 'error';

        $code = 200;

        if (!$network_id || !$new_status)
            return response()->json($data, $code);

        $network = UserNetwork::where('id', '=', $network_id)->first();

        if ($network) {

            DB::beginTransaction();

            try {

                $network->status = $new_status;

                $network->save();

                $data['status'] = 'success';

                if ($new_status == UserNetwork::STATUS_SPONSOR_DISAPPROVED)
                    $data['message'] = 'Successfully Declined Member';
                else if ($new_status == UserNetwork::STATUS_SPONSOR_APPROVED)
                    $data['message'] = 'Successfully Approved Member';

                DB::commit();
            } catch (\Exception $ex) {

                $data['message'] = 'Ooops, Something went wrong';

                DB::rollBack();
            }
        }

        return response()->json($data, $code);
    }
}
