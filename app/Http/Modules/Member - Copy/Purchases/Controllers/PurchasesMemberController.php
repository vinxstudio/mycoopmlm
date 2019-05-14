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

class PurchasesMemberController extends MemberAbstract{

    use ProductsTrait;
    protected $viewpath = 'Member.Purchases.views.';

    protected $available_status = 0;
    protected $used_status = 1;

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        return redirect('member/purchases/encode');
    }

    function getEncode($id = 0){

        $purchaseCode = PurchaseCodes::find($id);
        if (isset($purchaseCode->id)) {
            if ($purchaseCode->status > 0) {
                return redirect('member/purchases/encode')->with('danger', "You can't use that purchase code anymore");
            } else if ($purchaseCode->owner_id != $this->theUser->id) {
                return redirect('member/purchases/encode')->with('danger', "Purchase Code does not exist.");
            }

        }
        return view( $this->viewpath . 'encode' )
            ->with([
                'accounts'=>$this->theUser->accounts()->get(),
                'purchases'=>Purchases::whereDate('created_at', '=', date('Y-m-d'))->get(),
                'purchaseCode'=>$purchaseCode
            ]);

    }

    function postEncode(Request $request){

        $rules = [
            'code'=>'required',
            'password'=>'required'
        ];

        $validation = Validator::make($request->input(), $rules);

        $result = new \stdClass();

        $result->error = false;
        $result->message = '';

        $check = PurchaseCodes::where([
            'code'=>$request->code,
            'password'=>$request->password,
            'status'=>$this->available_status
        ])->get();

        if ($validation->fails()){
            $result->error = true;
        } else {

            if ($check->isEmpty()){
                $result->error = true;
                $result->message = Lang::get('products.invalid_code_or_password');
            }

        }

        if (!$result->error){

            DB::beginTransaction();
            try {
                $code = $check->first();

                $product = $code->product;

                $purchase = new Purchases();
                $purchase->user_id = $this->theUser->id;
                $purchase->account_id = $request->account_id;
                $purchase->product_id = $code->product_id;
                $purchase->code_id = $code->id;
                $purchase->amount = $product->price;
                $purchase->save();

                $purchaseCode = PurchaseCodes::find($code->id);
                $purchaseCode->status = $this->used_status;
                $purchaseCode->save();

                $thisMonthPurchase = Purchases::whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->sum('amount');

                $companyMinimumPurchase = $this->theCompany->minimum_product_purchase;
                if ($companyMinimumPurchase > 0 and $thisMonthPurchase >= $companyMinimumPurchase and $this->theUser->is_maintained == 'false'){
                    $this->theUser->is_maintained = 'true';
                    $this->theUser->save();
                }

                $query = ($this->theCompany->product_unilevel == 'universal') ? ProductUnilevel::orderBy('level', 'asc')->get() : ProductUnilevel::where('product_id', $code->product_id)->orderBy('level', 'ASC')->get();

                $compensation = [];

                foreach ($query as $row) {
                    $compensation['level-' . $row->level] = $row->amount;
                }

                $global_pool = ($product->global_pool > 0) ? calculatePercentage($product->global_pool, $product->price) : 0;

                $rebates = ($product->rebates > 0) ? calculatePercentage($product->rebates, $product->price) : 0;

                if ($this->theUser->is_maintained == false){
                    $rebates = 0;
                }

                $charge = config('system.rebates_charge');
                if ($rebates > 0 and $charge > 0){
                    $eWallet = calculatePercentage($charge, $rebates);
                    $wallet = new EWallet();
                    $wallet->account_id = $request->account_id;
                    $wallet->user_id = $this->theUser->id;
                    $wallet->source = $this->rebatesEarningKey;
                    $wallet->amount = $eWallet;
                    $wallet->save();
                    $rebates = $rebates - $eWallet;
                }

                $companyIncome = $product->price - ($global_pool + $rebates);

                $earnings = new Earnings();
                $earnings->account_id = $request->account_id;
                $earnings->user_id = $this->theUser->id;
                $earnings->source = $this->rebatesEarningKey;
                $earnings->amount = $rebates;
                $earnings->purchase_code_id = $code->id;
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

                            if ($thisUpline->user->is_maintained == false){
                                $unilevelEarnings = 0;
                            }

                            $charge = config('system.unilevel_charge');
                            if ($unilevelEarnings > 0 and $charge > 0){
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
            } catch (\Exception $e){
                DB::rollback();
                $result->error = true;
                $result->message = $this->formatException($e);
            }

        }

        return ($result->error) ? redirect('member/purchases/encode')->withInput()->withErrors($validation->errors())
            ->with('danger', $result->message) : redirect('member/purchases/encode')->with('success', $result->message);

    }

    function getHistory(){

        $purchases = Purchases::orderBy('id', 'DESC')->where('user_id', $this->theUser->id)->paginate($this->records_per_page);

        return view( $this->viewpath . 'history' )
            ->with([
                'purchases'=>$purchases
            ]);

    }

    function getBuy(){
        return view( $this->viewpath . 'buyCodes' )
            ->with([
                'productsDropdown'=>$this->getProductsList($withPrice = true)->dropdown,
                'codes'=>PurchaseCodes::where([
                    'owner_id'=>$this->theUser->id
                ])->paginate($this->records_per_page)
            ]);
    }

    function postBuy(Request $request){

        $product = Products::find($request->product);

        $totalPurchase = $product->purchaseValue * $request->quantity;

        if ($totalPurchase > $this->theUser->remainingBalance){
            return back()->with('danger', "You don't have enough balance to purchase codes.");
        } else {
            $admin = new ProductsAdminController();
            return $admin->postPurchaseCodes($request, $this->theUser->id);
        }

    }

}