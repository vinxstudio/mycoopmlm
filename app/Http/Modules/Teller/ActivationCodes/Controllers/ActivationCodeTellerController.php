<?php namespace App\Http\Modules\Teller\ActivationCodes\Controllers;

use App\Http\AbstractHandlers\TellerAbstract;
use App\Http\Modules\Teller\ActivationCodes\Validation\ActivationCodeValidationHandler;
use App\Http\Requests;
use App\Models\Accounts;
use App\Models\ActivationCodeBatches;
use App\Models\ActivationCodes;
use App\Models\Membership;
use App\Models\ForMaintenance;
use App\Models\User;
use App\Models\Products;
use App\Models\Purchases;
use App\Models\PurchaseCodes;
use App\Models\ProductPurchase;
use App\Models\PurchasesProducts;
use App\Models\ProductUnilevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Models\PurchaseCodesBought;
use App\Models\ProductPointsEquivalent;
use Stripe\Account;
use Illuminate\Support\Facades\Log;
use App\Models\AccountRedudantPoints;
use App\Models\AccountRedudantPointsHistory;
use App\Commands\CalculatePairedRedundantPoints;
use Illuminate\Support\Facades\Bus;

class ActivationCodeTellerController extends TellerAbstract
{

    protected $viewpath = 'Teller.ActivationCodes.views.';
    protected $sponsor_id = [];

    function __construct()
    {
        parent::__construct();
    }

    function sponsor_ids($x, $id = null)
    {
        $sponsor_id = DB::table('accounts')
            ->select('sponsor_id')
            ->where('id', $id)
            ->groupBy('sponsor_id')
            ->get();

        if ($id && $x != 0) {
            $this->sponsor_id[] = isset($sponsor_id[0]->sponsor_id) ? $sponsor_id[0]->sponsor_id : -1;
            self::sponsor_ids($x - 1, isset($sponsor_id[0]->sponsor_id) ? $sponsor_id[0]->sponsor_id : -1);
        }
        return;
    }

    function getIndex()
    {

        //$membership = Membership::find(0);
        return view($this->viewpath . 'index')
            ->with(
                [
                    'batches' => ActivationCodeBatches::paginate(50),
                    'membership' => Membership::paginate(50),
                    'date_from' => '',
                    'date_to' => '',
                ]
            );
    }

    function postIndex(Request $request)
    {
        // pr($request->input()); die($request->step_3);
        if ($request->type == 'generate_activation_codes') {

            $codeValidator = new ActivationCodeValidationHandler();
            $codeValidator->setTellerId($this->theUser->id);
            $codeValidator->setInputs($request->input());

            $result = $codeValidator->validate2();

            // $limit = $request->input("quantity-1") + $request->input("quantity-2") + $request->input("quantity-3");
            $limit = array_sum(explode(',', $request->no_of_codes));
            $last_id = DB::select('SELECT id FROM activation_codes ORDER BY id DESC LIMIT ' . $limit);

            if ($request->hasFile('receipt_image')) {
                $image = $request->file('receipt_image');
                $destinationPath = public_path('uploads/receipt/activation_codes');
                $name = 'receipt_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $name);
                foreach ($last_id as $id) {
                    $activation_codes = ActivationCodes::find($id->id);
                    $activation_codes->receipt = $name;
                    $activation_codes->save();
                }
            }

            $username = isset($result->username) ? $result->username : '--no--exist--';

            $data = array(
                'result' => $result,
                'redirect' => '/teller/activation-codes/view-batch/' . $username,
                'success' => 'generate_activation_codes'
            );

            echo json_encode($data);

            Session::flash($result->message_type, $result->message);

            /**
             * if success 
             */

            if (!$result->error) {
                $prod_code = $request->product_code;
                $prod_password = $request->product_password;

                $prodct_code = PurchaseCodes::where(['code' => $prod_code, 'password' => $prod_password])->first();

                if ($prodct_code) {

                    $prodct_code->status = PurchaseCodes::STATUS_ACTIVATED;

                    $prodct_code->save();
                }
            }

            // return ($result->error) ? redirect('teller/activation-codes')->withErrors($result->message)->withInput() : redirect('teller/activation-codes/view-batch/'.$result->username);
        } elseif ($request->type == 'product_purchase') {

            $user = new User();

            $accounts = $user->getAccountsByUsername($request->username);

            $account_points = [];
            $account_points_history = [];
            $uplines = $this->upline($accounts->account_id);

            $products = explode(',', $request->products);
            $quantity = explode(',', $request->quantity);
            $product_id = explode(',', $request->product_id);
            $product_type = explode(',', $request->product_type);

            $name = '';

            if ($request->hasFile('receipt_image')) {
                $image = $request->file('receipt_image');
                $destinationPath = public_path('uploads/receipt/product_purchase');
                $name = 'receipt_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $name);
            }

            $data = array();
            $data1 = array();
            $Purchases = new Purchases([
                'user_id' => $accounts->user_id,
                'account_id' => $accounts->account_id,
                'status' => Purchases::STATUS_PICK_UP,
                'branch_id' => $this->theUser->branch_id
            ]);

            $Purchases->save();

            for ($i = 0; $i < count($products); $i++) {

                if (!$quantity[$i]) continue;

                $productDetail = Products::where('name', $products[$i])->first();

                if (!$productDetail) continue;

                $PurchasesProducts = new PurchasesProducts([
                    'purchase_id' => $Purchases->id,
                    'product_id' => $productDetail->id,
                    'amount' => $productDetail->price,
                    'rebates' => $productDetail->rebates,
                    'quantity' => $quantity[$i]
                ]);
                $PurchasesProducts->save();

                if (!isset($PurchasesProducts->id)) continue;

                $prod_type = PurchaseCodes::PRODUCT_TYPE_SRP;

                if ($product_type[$i] == 'mp')
                    $prod_type = PurchaseCodes::PRODUCT_TYPE_MEMBERS_PRICE;

                for ($x = 0; $x < $quantity[$i]; $x++) {

                    # get unused product codes
                    # using product_id
                    # where branch id is equal to the theUser branch id
                    # where status is transferred
                    # where status is un used

                    $product_code = PurchaseCodes::where(['product_id' => $product_id[$i], 'product_type' => $prod_type, 'branch_id' => $this->theUser->branch_id, 'status' => PurchaseCodes::STATUS_TRANSFERED])->where('status', '!=', PurchaseCodes::STATUS_USED)->first();

                    # create new product codes bought
                    $bought = new PurchaseCodesBought();

                    $bought->purchase_id = $Purchases->id;
                    $bought->purchases_products_id = $PurchasesProducts->id;
                    $bought->product_code = $product_code->code;

                    if (!$bought->save())
                        continue;

                    # after purchase product save
                    # change status
                    $product_code->status = PurchaseCodes::STATUS_USED;
                    # change the new owner of the product_id
                    # the value of owner_id is the account id of the user
                    $product_code->owner_id = $accounts->account_id;
                    # save
                    $product_code->save();

                    /**
                     * Redundant Binary
                     * 
                     * Populate Redundant Points and Redundant Points History
                     */
                    if ($product_code->product_type == PurchaseCodes::PRODUCT_TYPE_MEMBERS_PRICE) {
                        $this->redundant_binary($account_points, $account_points_history, $product_code->product_id, $product_code->code, $accounts->account_id, $uplines);
                    }
                    /**
                      * End of Redundant Binary
                      */
                }

                #$PurchaseCodes = new PurchaseCodes([
                #    'product_id' => $productDetail->id,
                #    'code' => "",
                #    'password' => "",
                #    'status' => PurchaseCodes::STATUS_USED,
                #    'owner_id' => $accounts->account_id,
                #    'purchase_value' => $productDetail->rebates
                #]);
                #$PurchaseCodes->save();

                $product_purchase = new ProductPurchase();
                $product_purchase->teller_id = $this->theUser->id;
                $product_purchase->account_id = $accounts->account_id;
                $product_purchase->quantity = $quantity[$i];
                $product_purchase->type = $products[$i];
                $product_purchase->or = $request->ornumber;
                $product_purchase->payors_name = $request->payorname;
                $product_purchase->created_at = date('Y-m-d H:i:s');
                $product_purchase->receipt = $name;
                $product_purchase->payment_method = $request->method;
                $product_purchase->save();

                $product_unilevel = DB::table('product_unilevel')
                    ->select('product_unilevel.level', 'product_unilevel.amount', 'product_unilevel.product_id')
                    ->leftJoin('products', 'product_unilevel.product_id', '=', 'products.id')
                    ->where('products.name', $products[$i])
                    ->get();

                if ($product_unilevel) {
                    $x = count($product_unilevel);

                    $this->sponsor_id[] = $accounts->account_id;
                    self::sponsor_ids($x, $accounts->account_id);

                    for ($ii = 0; $ii < count(array_unique($this->sponsor_id)); $ii++) {

                        if ($ii >= 9) continue;
                        /**
                         * continue next iterator if
                         * sponsor id = -1
                         */
                        if ($this->sponsor_id[$ii] == -1) continue;

                        $data1[] = array(
                            'account_id' => $accounts->account_id,
                            'sponsor_id' => $this->sponsor_id[$ii + 1],
                            'product_purchase_id' => $product_purchase->id,
                            'purchase_product_id' => $PurchasesProducts->id,
                            'product_purchase_via' => 'teller',
                            'level' => $product_unilevel[$ii + 1]->level,
                            'amount' => ($product_unilevel[$ii + 1]->amount * $quantity[$i]),
                            'created_at' => date('Y-m-d H:i:s')
                        );
                    }
                }
            }

            DB::table('product_incentive')->insert($data1);
            $data = array(
                'success' => 'product_purchase',
                'result' => 'Product purchased successfully submitted'
            );


            echo json_encode($data);

            Session::flash('success', 'Product purchased successfully submitted');

            /**
             * Redundant Binary
             */
            DB::beginTransaction();
            try {
                for ($i = 0; $i < count($account_points); $i++) {

                    $account_id = $account_points[$i]['account_id'];

                    $redundant = AccountRedudantPoints::firstOrCreate(['account_id' => $account_id]);

                    $redundant->left_points_value += $account_points[$i]['left_points_value'];
                    $redundant->right_points_value += $account_points[$i]['right_points_value'];

                    $redundant->save();

                    $account_points_history[$i]['created_at'] = Carbon::now();
                    $account_points_history[$i]['updated_at'] = Carbon::now();
                    $account_points_history[$i]['account_redundant_points_id'] = $redundant->id;

                    Bus::dispatch(new CalculatePairedRedundantPoints($redundant));
                }

                AccountRedudantPointsHistory::insert($account_points_history);

                DB::commit();
            } catch (\Exception $e) {

                Log::debug('Redundant Binary Error');
                Log::debug('Date : ' . Carbon::now());
                Log::debug('File : ' . $e->getFile());
                Log::debug('Exception : ' . get_class($e));
                Log::debug('Error : ' . $e->getTraceAsString());

                Session::flash('success', 'Product purchased successfully submitted, but no redundant points added for the uplines');

                DB::rollback();
            }

            /**
              * End of Redundant Binary
              */
        } else {
            #get account
            $user = new User();

            $accounts = $user->getAccountsByUsername($request->username);

            $for_maintenance = new ForMaintenance();

            $for_maintenance->teller_id = $this->theUser->id;
            $for_maintenance->account_id = $accounts->account_id;
            $for_maintenance->cbu = $request->cbu;
            $for_maintenance->my_c = $request->myc;
            $for_maintenance->or = $request->ornumber;
            $for_maintenance->payors_name = $request->payorname;
            $for_maintenance->created_at = date('Y-m-d H:i:s');
            $for_maintenance->payment_method = $request->method;

            if ($request->hasFile('receipt_image')) {
                $image = $request->file('receipt_image');
                $destinationPath = public_path('uploads/receipt/maintenance');
                $name = 'receipt_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $name);
                $for_maintenance->receipt = $name;
            }

            $for_maintenance->save();

            $data = array(
                'success' => 'for_maintenance',
                'result' => 'For maintenance successfully submitted'
            );

            echo json_encode($data);

            Session::flash('success', 'For maintenance successfully submitted');
        }
    }

    function getViewBatch($username = null, $date_from = null, $date_to = null)
    {

        // http://app.mycoop.com/teller/activation-codes/view-batch/billy.pilapil

        $code_dates = ActivationCodes::select('created_at')
            ->where('teller_id', $this->theUser->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $month_range = array();
        foreach ($code_dates as $dates) {
            // $month_year =  Carbon::parse($dates['created_at'])->format('F, Y');
            // $month_num = Carbon::parse($dates['created_at'])->month;
            $startDate = date('Y-m-01', strtotime($dates->created_at));
            $endDate = date('Y-m-t', strtotime($dates->created_at));

            $start_date_index = date("Y-m-d", strtotime($startDate)) . ' 00:00:01';
            $end_date_index = date("Y-m-d", strtotime($endDate)) . ' 23:59:59';

            $date_range_index = $start_date_index . '_' . $end_date_index;

            if (!in_array($date_range_index, $month_range)) {
                $month_range[$date_range_index] = Carbon::parse($startDate)->format('F d, Y') . ' - ' . Carbon::parse($endDate)->format('F d, Y');
            }
        }

        if (empty($date_from) && empty($date_to)) {
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');

            $start_date_index = date("Y-m-d", strtotime($startDate)) . ' 00:00:01';
            $end_date_index = date("Y-m-d", strtotime($endDate)) . ' 23:59:59';

            $date_from = $start_date_index;
            $date_to = $end_date_index;
        }

        $activation_codes = new ActivationCodes;
        $q = $activation_codes->getActivationCodes();

        $q->where('transferred_to', $username);
        if (!empty($date_from)) {
            $q->where('activation_codes.created_at', '>=', $date_from);
        }

        if (!empty($date_to)) {
            $q->where('activation_codes.created_at', '<=', $date_to);
        }

        $codes = $q->paginate(10);

        return view($this->viewpath . 'view-codes')->with(
            [
                'codes' => $codes,
                'username' => $username,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'month_range' => $month_range,
            ]
        );
    }

    function postViewBatch($username = null, Request $request)
    {
        $month_range = explode('_', $request->month);
        return redirect('/teller/activation-codes/view-batch/' . $username . '/' . $month_range[0] . '/' . $month_range[1]);
    }

    function getViewActivationCode($date_from = '', $date_to = '')
    {
        // http://app.mycoop.com/teller/activation-codes/view-batch/billy.pilapil
        $code_dates = ActivationCodes::select('created_at')
            ->where('teller_id', $this->theUser->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $month_range = array();
        foreach ($code_dates as $dates) {
            // $month_year =  Carbon::parse($dates['created_at'])->format('F, Y');
            // $month_num = Carbon::parse($dates['created_at'])->month;
            $startDate = date('Y-m-01', strtotime($dates->created_at));
            $endDate = date('Y-m-t', strtotime($dates->created_at));

            $start_date_index = date("Y-m-d", strtotime($startDate)) . ' 00:00:01';
            $end_date_index = date("Y-m-d", strtotime($endDate)) . ' 23:59:59';

            $date_range_index = $start_date_index . '_' . $end_date_index;

            if (!in_array($date_range_index, $month_range)) {
                $month_range[$date_range_index] = Carbon::parse($startDate)->format('F d, Y') . ' - ' . Carbon::parse($endDate)->format('F d, Y');
            }
        }

        if (empty($date_from) && empty($date_to)) {
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');

            $start_date_index = date("Y-m-d", strtotime($startDate)) . ' 00:00:01';
            $end_date_index = date("Y-m-d", strtotime($endDate)) . ' 23:59:59';

            $date_from = $start_date_index;
            $date_to = $end_date_index;
        }



        $activation_codes = new ActivationCodes;
        $q = $activation_codes->getActivationCodes();

        $q->where('teller_id', $this->theUser->id);

        if (!empty($date_from)) {
            $q->where('activation_codes.created_at', '>=', $date_from);
        }

        if (!empty($date_to)) {
            $q->where('activation_codes.created_at', '<=', $date_to);
        }

        $codes = $q->paginate(10);

        return view($this->viewpath . 'view-codes')->with(
            [
                'codes' => $codes,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'month_range' => $month_range,
            ]
        );
    }

    function postDeleteCode(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'activation_id' => 'required',
            'delete_reason' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => "Reason field is required!"]);
        }

        $code = ActivationCodes::where('id', $request->activation_id)
            ->update([
                'status' => 'cancelled',
                'reason' => $request->input('delete_reason')
            ]);
        if ($code) {
            return response()->json(['message' => "Success!"]);
        }
    }

    function getReason($id)
    {
        $code = ActivationCodes::select('reason')->where('id', $id)->first();

        if ($code) {
            return response()->json($code);
        }
    }

    function postViewActivationCode(Request $request)
    {
        $month_range = explode('_', $request->month);
        return redirect('teller/activation-codes/view-activation-code/' . $month_range[0] . '/' . $month_range[1]);
    }

    function getForMaintenance()
    {
        return view($this->viewpath . 'for-maintenance')->with([
            'maintenances' => ForMaintenance::select([
                'for_maintenance.*',
                'DT.first_name as T_fname',
                'DT.middle_name as T_mname',
                'DT.last_name as T_lname',
                'UM.username as M_username',
                'DM.first_name as M_fname',
                'DM.middle_name as M_mname',
                'DM.last_name as M_lname',
            ])
                ->where('for_maintenance.teller_id', $this->theUser->id)
                ->leftJoin('accounts as M', 'for_maintenance.account_id', '=', 'M.id')
                ->leftJoin('users as UT', 'for_maintenance.teller_id', '=', 'UT.id')
                ->leftJoin('users as UM', 'M.user_id', '=', 'UM.id')
                ->leftJoin('user_details as DT', 'UT.user_details_id', '=', 'DT.id')
                ->leftJoin('user_details as DM', 'UM.user_details_id', '=', 'DM.id')
                ->paginate(50)
        ]);
    }

    function exportFile($type, $username = null, $date_from = null, $date_to = null)
    {

        $date_from = (!empty($date_from)) ? $date_from : '';
        $date_to = (!empty($date_to)) ? $date_to : '';

        $activation_codes = new ActivationCodes;
        $q = $activation_codes->getActivationCodes();

        if (!empty($username)) {
            $q->where('transferred_to', $username);
        } else {
            $q->where('teller_id', $this->theUser->id);
        }

        if (!empty($date_from)) $q->where('activation_codes.created_at', '>=', $date_from);
        if (!empty($date_to)) $q->where('activation_codes.created_at', '<=', $date_to);

        $codes = $q->get();


        return \Excel::create('Activation_Code', function ($excel) use ($codes) {

            $excel->sheet('Activation_Code', function ($sheet) use (&$codes) {
                $sheet->loadView($this->viewpath . 'code_list_excel')
                    ->withCodes($codes);
            });
        })->download($type);
    }

    function getPackage()
    {
        $package_list = DB::table('membership_settings')->get();

        echo json_encode($package_list);
    }

    // function getProducts(Products $products)
    // {
    //     // return view('ecommerce.show', $products);
    //     echo json_encode($products);
    // }

    /**
     * 
     * Change SRP => Members Price, vice versa
     * --
     * get the products left of SRP or MP
     * @param product_type
     * 
     */
    # Get Request for Retrieving Products
    function getProducts(Request $request)
    {
        #$products = DB::table('products')->get();

        $user = \Auth::user();

        if ($request->product_id && $request->product_type) {

            $product_id = $request->product_id;
            $product_type = $request->product_type;

            $product_type = ($product_type == 'srp') ? PurchaseCodes::PRODUCT_TYPE_SRP : PurchaseCodes::PRODUCT_TYPE_MEMBERS_PRICE;

            $products = PurchaseCodes::selectRaw('count(*) as products_left, product_purchase_codes.product_type, product_purchase_codes.status, product_purchase_codes.product_id')
                ->where([
                    'product_id' => $product_id,
                    'branch_id' => $user->branch_id,
                    'product_type' => $product_type,
                    'status' => PurchaseCodes::STATUS_TRANSFERED
                ])
                ->where('status', '!=', PurchaseCodes::STATUS_USED)
                ->first();
        } else {

            # get products
            # left join with product codes
            # count how many product codes in a product
            $products = Products::selectRaw('products.*, count(product_purchase_codes.id) as products_left, product_purchase_codes.product_type')
                ->leftJoin('product_purchase_codes', function ($join) use ($user) {
                    $join->on('product_purchase_codes.product_id', '=', 'products.id');
                    #
                    # SRP is the default when Product Purchase is Open
                    # PurchaseCodes::PRODUCT_TYPE_SRP = 'SRP'
                    #
                    $join->where('product_purchase_codes.product_type', '=', PurchaseCodes::PRODUCT_TYPE_SRP);
                    $join->where('product_purchase_codes.branch_id', '=', $user->branch_id);
                    $join->where('product_purchase_codes.status', '=', PurchaseCodes::STATUS_TRANSFERED);
                    $join->where('product_purchase_codes.status', '!=', PurchaseCodes::STATUS_USED);
                })
                ->groupBy('products.id')
                ->get();
        }

        #echo json_encode($products);
        return $products;
    }


    # Retrieve count of how many product codes for
    # the product in this branch
    # @param product id of the product
    #
    function getIfHaveProductCodesInBranch()
    {
        $product_id = $_GET['product_id'];
        $product_type = $_GET['product_type'];

        # get branch id of this account
        $branch_id = $this->theUser->branch_id;
        # retrieve product codes and count them
        # where status is transferred
        # where status is not equal to used
        $data = PurchaseCodes::where(['product_id' => $product_id, 'branch_id' => $branch_id, 'status' => PurchaseCodes::STATUS_TRANSFERED, 'product_type' => $product_type])->where('status', '!=', PurchaseCodes::STATUS_USED)->count();
        # if exist
        if ($data) {
            return response()->json(['status' => 'success', 'message' => 'Successfully retrieve number of codes in this branch', 'count' => $data], 200);
        }
        # if not
        return response()->json(['status' => 'error', 'message' => 'No product codes in this branch for this product', 'count' => 0], 200);
    }

    /**
     * 
     * Validate Product Code and Password
     * 
     */

    function getProductCode(Request $request)
    {
        $username = $request->username;

        $status = 'Error';
        $message = 'No product code available for this account';
        $code = 400;

        if ($username && $username != '') {

            $user = new User();

            $account = $user->getAccountsByUsername($username);

            $product_code = PurchaseCodes::select('id', 'code', 'password', 'status', 'owner_id')->where(['owner_id' => $account->account_id, 'status' => PurchaseCodes::STATUS_USED])->first();

            if ($product_code) {
                $status = 'Success';
                $message = $product_code;
                $code = 200;
            }
        }

        return response()->json(['status' => $status, 'message' => $message], $code);
    }

    function getValidateProductCode(Request $request)
    {
        $username = $request->username;
        $product_code = $request->product_code;
        $product_password = $request->product_password;
        $generate = $request->generate_activation_codes;

        $status = 'Success';
        $message = 'Its not for Generate Activation Codes';
        $code = 200;

        if ($generate == 'true') {

            $user = new User();
            $account = $user->getAccountsByUsername($username);

            $status = 'Error';
            $message = [
                'product_code' => 'Invalid Product Code'
            ];
            $code = 400;

            if ($product_code == '')
                $message['product_code'] = 'Product Code is required';

            if ($account) {

                $purchase_code = PurchaseCodes::select('id', 'code', 'password', 'password', 'status', 'owner_id')->where(['code' => $product_code, 'status' => PurchaseCodes::STATUS_USED])->first();

                if ($purchase_code) {

                    unset($message['product_code']);

                    if ($purchase_code->password != $product_password)
                        $message['product_password'] = 'Invalid Product Code Password';

                    if ($purchase_code->owner_id != $account->account_id)
                        $message['owner_id'] = 'Invalid Owner of the Product Code';

                    if ($purchase_code->password == $product_password && $purchase_code->owner_id == $account->account_id) {
                        $status = 'Success';
                        $code = 200;
                    }
                } else {
                    unset($message['product_password']);
                }
            }
        }

        return response()->json(['status' => $status, 'data' => $message], $code);
    }

    /**
     * End of Product Code Validation
     */




    /**
      * Redundant Binary
      */

    function redundant_binary(&$redundant_points, &$redundant_points_history, $product_id, $product_code, $purchaser_id, $accounts_ids)
    {

        $points_value = Products::where('id', $product_id)->pluck('points_value');

        if (!$points_value || $points_value == -1) {
            return null;
        }

        for ($i = 0; $i < count($accounts_ids); $i++) {

            $account_id = $accounts_ids[$i]['upline_id'];
            $node = $accounts_ids[$i]['upline_node'];

            $left_points_value = 0;
            $right_points_value = 0;

            if ($node != 'left' && $node != 'right') {
                return;
            } else if ($node == 'left') {
                $left_points_value = $points_value;
            } else if ($node == 'right') {
                $right_points_value = $points_value;
            }

            $redundant_points[] = [
                'account_id' => $account_id,
                'left_points_value' => $left_points_value,
                'right_points_value' => $right_points_value,
            ];

            $redundant_points_history[] = [
                'type' => 'add_points',
                'points_node' => $node,
                'amount' => $points_value,
                'product_code_use' => $product_code,
                'purchase_account_id' => $purchaser_id
            ];
        }
    }


    function upline($account_id)
    {

        $accounts_id = [];

        $nth_level = ProductPointsEquivalent::where('id', ProductPointsEquivalent::REDUNDANT_BINARY_SETTINGS)->pluck('up_to_level');

        for ($i = 0; $i < $nth_level; $i++) {

            $account = Accounts::select('upline_id', 'node')->where('id', $account_id)->first();

            if ($account) {

                $account_id = $account->upline_id;

                $upline_id = $account->upline_id;
                $upline_node = $account->node;

                $accounts_id[] = [
                    'upline_id' => $upline_id,
                    'upline_node' => $upline_node
                ];
            }
        }

        return $accounts_id;
    }



    /**
       * End of Redundant Binary
       * 
       */
}
