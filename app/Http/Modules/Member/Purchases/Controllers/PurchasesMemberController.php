<?php

/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/8/17
 * Time: 9:24 PM
 */

namespace App\Http\Modules\Member\Purchases\Controllers;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Modules\Admin\Products\Controllers\ProductsAdminController;
use App\Http\TraitLayer\ProductsTrait;
use App\Models\Accounts;
use App\Models\Company;
use App\Models\CompanyEarnings;
use App\Models\Earnings;
use App\Models\EWallet;
use App\Models\MoneyPot;
use App\Models\Products;
use App\Models\ProductUnilevel;
use App\Models\PurchaseCodes;
use App\Models\Purchases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EncodeProductCodes;
use Stripe\Collection;
use Stripe\Account;
use App\Models\PurchaseCodesBought;

class PurchasesMemberController extends MemberAbstract
{

    use ProductsTrait;
    protected $viewpath = 'Member.Purchases.views.';

    protected $available_status = 0;
    protected $used_status = 1;

    function __construct()
    {
        parent::__construct();
    }

    function getIndex()
    {
        return redirect('member/purchases/encode');
    }

    function getEncode($id = 0)
    {

        $purchaseCode = PurchaseCodes::find($id);
        if (isset($purchaseCode->id)) {
            if ($purchaseCode->status > 0) {
                return redirect('member/purchases/encode')->with('danger', "You can't use that purchase code anymore");
            } else if ($purchaseCode->owner_id != $this->theUser->id) {
                return redirect('member/purchases/encode')->with('danger', "Purchase Code does not exist.");
            }

        }

        $purchases = Purchases::where('user_id', $this->theUser->id)->whereDate('created_at', '=', date('Y-m-d'))->get();

        return view($this->viewpath . 'encode')
            ->with([
                'accounts' => $this->theUser->accounts()->get(),
                'purchases' => $purchases,
                'purchaseCode' => $purchaseCode
            ]);

    }

    function postEncode(Request $request)
    {
        //Server side checking
        $rules = [
            'code' => 'required',
            'password' => 'required'
        ];
        $validation = Validator::make($request->input(), $rules);
        
        //Initialize output variables
        $result = new \stdClass();
        $result->message = 'Please check inputs.';
        
        //Get Purchase Code to be bought
        $PurchaseCode = PurchaseCodes::where([
            'code' => $request->code,
            'password' => $request->password,
            'status' => $this->available_status
        ])->first();

        //Check validation, if failed redirect with errors
        if ($validation->fails()) {
            return redirect('member/purchases/encode')
                ->withInput()
                ->withErrors($validation->errors())
                ->with('danger', $result->message);
        }

        //Check purchased products, if empty return with empty purchase alert
        if (!$PurchaseCode || !$PurchaseCode->product) {
            return redirect('member/purchases/encode')
                ->withInput()
                ->withErrors($validation->errors())
                ->with('danger', Lang::get('products.invalid_code_or_password'));
        }

        //Start insertions
        try {
            DB::beginTransaction();
            
            //Save as purchases
            $purchase = new Purchases();
            $purchase->user_id = $this->theUser->id;
            $purchase->account_id = $request->account_id;
            $purchase->product_id = $PurchaseCode->product_id;
            $purchase->code_id = $PurchaseCode->id;
            $purchase->amount = $PurchaseCode->product->price;
            $purchase->save();

            //Tag purchased code as used.
            $PurchaseCode->status = $this->used_status;
            $PurchaseCode->save();

            $thisMonthPurchase = Purchases::whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->sum('amount');

            $companyMinimumPurchase = $this->theCompany->minimum_product_purchase;
            if ($companyMinimumPurchase > 0 and $thisMonthPurchase >= $companyMinimumPurchase and $this->theUser->is_maintained == 'false') {
                $this->theUser->is_maintained = 'true';
                $this->theUser->save();
            }

            $query = ($this->theCompany->product_unilevel == 'universal') ? ProductUnilevel::orderBy('level', 'asc')->get() : ProductUnilevel::where('product_id', $PurchaseCode->product_id)->orderBy('level', 'ASC')->get();

            $compensation = [];

            foreach ($query as $row) {
                $compensation['level-' . $row->level] = $row->amount;
            }

            $global_pool = ($PurchaseCode->product->global_pool > 0) ? calculatePercentage($PurchaseCode->product->global_pool, $PurchaseCode->product->price) : 0;

            $rebates = ($PurchaseCode->product->rebates > 0) ? calculatePercentage($PurchaseCode->product->rebates, $PurchaseCode->product->price) : 0;

            if ($this->theUser->is_maintained == false) {
                $rebates = 0;
            }

            $charge = config('system.rebates_charge');
            if ($rebates > 0 and $charge > 0) {
                $eWallet = calculatePercentage($charge, $rebates);
                $wallet = new EWallet();
                $wallet->account_id = $request->account_id;
                $wallet->user_id = $this->theUser->id;
                $wallet->source = $this->rebatesEarningKey;
                $wallet->amount = $eWallet;
                $wallet->save();
                $rebates = $rebates - $eWallet;
            }

            $companyIncome = $PurchaseCode->product->price - ($global_pool + $rebates);

            $earnings = new Earnings();
            $earnings->account_id = $request->account_id;
            $earnings->user_id = $this->theUser->id;
            $earnings->source = $this->rebatesEarningKey;
            $earnings->amount = $rebates;
            $earnings->purchase_code_id = $PurchaseCode->id;
            $earnings->save();

            if ($global_pool > 0) {

                $moneyPot = new MoneyPot();
                $moneyPot->amount = $global_pool;
                $moneyPot->source = $this->moneyPotProductPurchase;
                $moneyPot->save();

            }

            if (count($compensation) > 0) {
                $account = Accounts::find($request->account_id);

                $parent_id = $account->upline_id;

                $levelKeys = array_keys($compensation);
                $lastLevel = str_replace('level-', '', end($levelKeys));

                $currentLevel = 1;

                while ($parent_id > 0) {

                    if (isset($compensation['level-' . $currentLevel]) and $parent_id > 0) {

                        $unilevelEarnings = $compensation['level-' . $currentLevel];

                        $companyIncome -= $compensation['level-' . $currentLevel];
                        $thisUpline = Accounts::find($parent_id);

                        if ($thisUpline->user->is_maintained == false) {
                            $unilevelEarnings = 0;
                        }

                        $charge = config('system.unilevel_charge');
                        if ($unilevelEarnings > 0 and $charge > 0) {
                            $eWallet = calculatePercentage($charge, $unilevelEarnings);
                            $wallet = new EWallet();
                            $wallet->account_id = $thisUpline->id;
                            $wallet->user_id = $thisUpline->user_id;
                            $wallet->source = $this->unilevelEarningKey;
                            $wallet->amount = $eWallet;
                            $wallet->save();
                            $unilevelEarnings = $unilevelEarnings - $eWallet;
                        }

                        $earnings = new Earnings();
                        $earnings->account_id = $thisUpline->id;
                        $earnings->user_id = $thisUpline->user_id;
                        $earnings->source = $this->unilevelEarningKey;
                        $earnings->amount = $unilevelEarnings;
                        $earnings->save();
                        $parent_id = $thisUpline->upline_id;
                    } else {
                        break;
                    }

                    $currentLevel++;
                }

                $company = new CompanyEarnings();
                $company->amount = $companyIncome;
                $company->details = $this->moneyPotProductPurchase;
                $company->save();
                $result->message = Lang::get('products.encode_success');
            }

            DB::commit();
            return redirect('member/purchases/encode')->with('success', $result->message);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('member/purchases/encode')
                ->withInput()
                ->withErrors($validation->errors())
                ->with('danger', $this->formatException($e));
        }
    }

    function getHistory()
    {

        $purchases = Purchases::orderBy('id', 'DESC')->where('user_id', $this->theUser->id)->paginate($this->records_per_page);

        return view($this->viewpath . 'history')
            ->with([
                'purchases' => $purchases
            ]);

    }

    function getBuy()
    {
        return view($this->viewpath . 'buyCodes')
            ->with([
                'productsDropdown' => $this->getProductsList($withPrice = true)->dropdown,
                'codes' => PurchaseCodes::where([
                    'owner_id' => $this->theUser->id
                ])->paginate($this->records_per_page)
            ]);
    }

    function postBuy(Request $request)
    {

        $product = Products::find($request->product);

        $totalPurchase = $product->purchaseValue * $request->quantity;

        if ($totalPurchase > $this->theUser->remainingBalance) {
            return back()->with('danger', "You don't have enough balance to purchase codes.");
        } else {
            $admin = new ProductsAdminController();
            return $admin->postPurchaseCodes($request, $this->theUser->id);
        }

    }
    


    # January 13, 2019 
    # Remove Encode Product Code in member
    #
    // # encode for product codes
    // # redundant binary encode product codes
    // function getEncodeProductCodes()
    // {

    //     $accounts = $this->theUser->accounts()->get();

    //     return view($this->viewpath . 'encode_product_codes')->with([
    //         'accounts' => $accounts
    //     ]);
    // }

    // function postEncodedProductCodes(EncodeProductCodes $request)
    // {

    //     $code = $request->product_code;
    //     $password = $request->product_code_password;
    //     $account_id = $request->account_id;
    //     $use_user_id = $request->use_user_id;
    //     # errors
    //     $status = [];
    //     $errors = [];


    //     #
    //     # remove user id after next update
    //     # 
    //     $user_id = auth()->user()->id;

    //     $product_code = PurchaseCodes::select(
    //         'product_purchase_codes.code',
    //         'product_purchase_codes.password',
    //         'product_purchase_codes.owner_id',
    //         'product_purchase_codes.status',
    //         'purchases.created_at',
    //         'products.name',
    //         'products.price'
    //     )
    //         ->leftJoin('products', 'products.id', '=', 'product_purchase_codes.product_id')
    //         ->leftJoin('purchase_codes_boughts', 'purchase_codes_boughts.product_code', '=', 'product_purchase_codes.code')
    //         ->leftJoin('purchases', 'purchases.id', '=', 'purchase_codes_boughts.purchase_id')
    //         ->where(['code' => $code])->first();


    //     # if product code is null or empty
    //     if ($product_code == null || !$product_code) {

    //         $errors['product_code'] = 'The product code is invalid';

    //     }
    //     # if product code is used, or haven't bought yet
    //     else if ($product_code->status != PurchaseCodes::STATUS_BOUGHT) {

    //         $errors['product_code'] = 'The product code is either used or unbought';


    //     }
    //     # if product code password is != to password inputted
    //     else if ($product_code->password != $password) {

    //         $errors['product_code_password'] = 'The product code password is invalid';

    //     }
    //     # and if product owner id is != to account id
    //     else if ($product_code->owner_id != $account_id && $use_user_id != true) {

    //         $errors['account_id'] = 'This account has no access to this code';

    //         $status['isNotEqualAccountId'] = true;

    //         $account_user_id = Accounts::where('id', $account_id)->pluck('user_id');

    //         if ($account_user_id == $user_id) {

    //             $status['isNotEqualAccountIdData']['title'] = 'Account Invalid';
    //             $status['isNotEqualAccountIdData']['message'] = nl2br('Account is invalid for this code, but the same user. ' . "\r\n" . ' Use the user of this account?');

    //         }

    //     } else {


    //         $status['type'] = 'success';
    //         $status['class'] = 'alert-success';
    //         $status['message'] = 'Encoded success';

    //         $purchases = $request->purchases;

    //         $purchases = ($purchases == '') ? collect([]) : $purchases;

    //         $purchases->push($product_code);

    //         return redirect()->back()->with([
    //             'status' => $status,
    //             'purchases' => $purchases
    //         ]);

    //     }


    //     return redirect()->back()->withInput()->withErrors($errors)->with([
    //         'status' => $status
    //     ]);



    // }


}