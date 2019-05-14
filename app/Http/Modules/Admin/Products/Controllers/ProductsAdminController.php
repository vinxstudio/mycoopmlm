<?php 

namespace App\Http\Modules\Admin\Products\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\Modules\Admin\Products\Validation\ProductValidationHandler;
use App\Http\Requests;
use App\Http\TraitLayer\ProductsTrait;
use App\Models\Products;
use App\Models\ProductUnilevel;
use App\Models\PurchaseCodes;
use App\Models\Purchases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use File;
use Storage;
use Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\MultidimensionalArrayHelper;
use App\Models\Branches;
use function GuzzleHttp\json_decode;
use App\Models\ProductPointsEquivalent;
use Carbon\Carbon;
use App\Models\TransferBranchHistory;
use App\Models\AccountRedudantPointsHistory;
use App\Models\Details;
use App\Models\Accounts;

class ProductsAdminController extends AdminAbstract
{

    use ProductsTrait;

    protected $viewpath = 'Admin.Products.views.';

    function __construct()
    {
        parent::__construct();
    }

    function getIndex()
    {
        return view($this->viewpath . 'index')
            ->with(
                [
                    'products' => Products::orderBy('id', 'asc')->paginate(50)
                ]
            );
    }

    function getForm($id = 0)
    {
        return view($this->viewpath . 'form')
            ->with([
                'product' => Products::find($id),
                'types' => Products::TYPES,
                'categories' => Products::CATEGORIES
            ]);
    }

    function postForm(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required|string|unique:products,slug,NULL|without_spaces',
            'price' => 'required|numeric',
            'rebates' => 'required|numeric',
            'points_value' => 'numeric',
            'description' => 'required',
            'publish' => 'required|numeric|in:1,0',
            'type' => 'required|numeric',
            'category' => 'required|numeric'
        ];

        if (isset($request['id']) && $request['id'] !== '') {
            $rules = array_merge($rules, [
                'slug' => 'required|string|unique:products,slug,' . $request->id . '|without_spaces'
            ]);
        }

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()
                ->back()
                ->withErrors($validate->errors())
                ->withInput();
        }

        try {
            if (isset($request['id']) && $request['id'] !== '') {
                $product = Products::find($request['id'])->fill($request->except(['id', 'image']));
            } else {
                $product = new Products($request->except(['id', 'image']));
            }
            $product->save();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $request->file('image')->move('public/products/', $file->getClientOriginalName());

                $product->image = $file->getClientOriginalName();
                $product->save();
            }

            return redirect('admin/products')->with('success', Lang::get('products.added'));
        } catch (\Exception $e) {
            return redirect('admin/products')
                ->withErrors($validate->errors())
                ->with('danger', $e);
        }
    }

    function getPurchaseCodes(Request $request)
    {
        # Search if just generated code
        $value = session('codes');

        # if value is null
        if (!$value) {
            # get value from database
            $value = PurchaseCodes::orderBy('created_at', 'desc')->orderBy('id', 'desc')->get()->toArray();
        }

        # instantiate a class to use for searching multi dimensional array search
        $multi_array = new MultidimensionalArrayHelper();

        # array for checking if the code generator of this product is the same
        $owners = [];

        /**
         * 
         * Assign New Purchase Codes To Value
         */

        $value = PurchaseCodes::where(['status' => PurchaseCodes::STATUS_UNUSED])->orderBy('created_at', 'DESC')->get()->toArray();

        # start looping for checking code generated product owner
        for ($i = 0; $i < count($value); $i++) {

            # get owner id from value
            $user_id = $value[$i]["generated_by"];

            # check if user id is not null and assign the user
            $user_id = ($user_id) ? $user_id : -1;

            # check if empty and check if owner id is already from $owners variable
            if (empty($owners) || !$multi_array->in_array_r($user_id, $owners)) {

                # get username of owner from $owner id
                $username = User::where("id", "=", $user_id)->pluck("username");

                $username = ($username) ? $username : 'N/A';

                # assing username
                $value[$i]["generated_by"] = $username;

                # create new owners array
                $newOwner = [
                    "owner_id" => $user_id,
                    "generated_by" => $username
                ];

                # push new owner array to $owner
                array_push($owners, $newOwner);
            } else {
                # if owner id exist in $owner varible
                foreach ($owners as $owner) {
                    # code...
                    # get owner name using owner id
                    if ($owner["owner_id"] == $user_id) {
                        $value[$i]["generated_by"] = $owner['generated_by'];
                    }
                }
            }
        }

        /**
         * Check if Have Filter Options
         * Check if Filter Options is true
         * 
         */
        $old_filter_price_type = '';
        $old_filter_product = '';
        $old_filter_branch = '';

        $filter_options = $request->filter_options;

        if ($filter_options) {

            $branch = $request->filter_branches;
            $product = $request->filter_product;
            $price_type = $request->filter_price_type;

            $params = [];
            $params['status'] = PurchaseCodes::STATUS_UNUSED;

            if ($branch && ($branch != 0 || $branch != -1)) {
                $old_filter_branch = $branch;
                $params['branch_id'] = $branch;
            }

            if ($product && ($product != 0 || $product != -1)) {
                $params['product_id'] = $product;
                $old_filter_product = $product;
            }

            if ($price_type && ($price_type != 0 || $price_type != -1)) {
                $params['product_type'] = $price_type;
                $old_filter_price_type = $price_type;
            }

            if (!empty($params)) {
                $value = PurchaseCodes::where($params)->orderBy('created_at', 'DESC')->get()->toArray();
            }
        }

        # Product Codes Pagination 

        # get current page { ?page=0,1,2,3 }
        $page = Session::has('codes') ? 0 : LengthAwarePaginator::resolveCurrentPage();

        # set the current page -1 to the page in page url
        $currentPage = $page - 1;

        # check if current page <= -1
        $currentPage = $currentPage < 0 ? 0 : $currentPage;

        # data per page
        $perPage = 10;

        # new collection 
        $collection = new Collection($value);

        # slice data from array to display for pagination
        $currentPageSearchResults = $collection->slice($currentPage * $perPage, $perPage)->all();

        # create new pagination
        $paginate = new LengthAwarePaginator($currentPageSearchResults, count($value), $perPage);

        $paginate->setPath(LengthAwarePaginator::resolveCurrentPath());

        # Pagination End

        # get all list of branches
        $branches = Branches::select('id', 'name')->get();

        session()->forget('codes');

        view()->share([
            'pagename' => 'purchase codes'
        ]);


        return view($this->viewpath . 'purchase_codes')
            ->with(
                [
                    'productsDropdown' => $this->getProductsList()->dropdown,
                    'price_type' => PurchaseCodes::PRODUCT_TYPE,
                    'codes' => $value,
                    'paginate' => $paginate,
                    'branches' => $branches,
                    'old_filter_branch' => $old_filter_branch,
                    'old_filter_product' => $old_filter_product,
                    'old_filter_price_type' => $old_filter_price_type
                ]
            );
    }

    # POST Method for Generating New Product Codes
    function postPurchaseCodes(Request $request, $member_id = 0)
    {
        /**
         * Comment the allocation generate branches
         */

        // $message = [
        //     'generate_branches.required' => 'Allocate to branch is required'
        // ];

        // $this->validate($request, [
        //     'generate_branches' => 'required'
        // ], $message);

        /**
         * End Comment
         */

        $validate = new ProductValidationHandler();
        $validate
            ->setInputs($request->input());

        if ($member_id > 0) {
            $validate->setMemberID($member_id);
        }

        $result = $validate->validatePurchaseCodes();

        Session::flash($result->message_type, $result->message);

        if ($result->error) {
            return back()->withErrors($result->validation->errors());
        }

        session(['codes' => $result->codes]);

        return back();
    }
    # End

    # PurchaseCodes Inventory
    function getPurchaseCodesInventory()
    {

        $total_product_all = '';
        $total_product_per = collect([]);

        $branch = '';
        $availability = '';
        $product_name = '';
        $date_from = '2018-12-01';
        $date_to = Carbon::now()->format('Y-m-d');

        $is_using_date = false;

        $codes_where_query = [];
        $total_product_all_where_query = [];
        $total_product_per_where_query = [];

        # Get Data for Select Options
        $branches = '';
        $products = '';

        # if GET params have branch_no
        if (!empty($_GET['branch_no'])) {
            $branch = $_GET['branch_no'];

            $codes_where_query['product_purchase_codes.branch_id'] = $branch;
            $total_product_all_where_query['branch_id'] = $branch;
            $total_product_per_where_query['branch_id'] = $branch;
        }
        # if GET params have product_availability
        if (!empty($_GET['product_availability'])) {
            $availability = $_GET['product_availability'];

            $status = 0;

            if ($availability == 'untransferred')
                $status = PurchaseCodes::STATUS_UNUSED;
            else if ($availability == 'available')
                $status = PurchaseCodes::STATUS_TRANSFERED;
            else if ($availability == 'bought')
                $status = PurchaseCodes::STATUS_USED;

            $codes_where_query['status'] = $status;
            $total_product_all_where_query['status'] = $status;
            $total_product_per_where_query['status'] = $status;
        }
        # if GET params have product name
        if (!empty($_GET['product_name'])) {
            $product_name = $_GET['product_name'];

            $prod_id = Products::where('slug', $product_name)->pluck('id');

            $codes_where_query['product_id'] = $prod_id;
            $total_product_all_where_query['product_id'] = $prod_id;
            $total_product_per_where_query['product_id'] = $prod_id;
        }
        # if GET params have date_from and date_to
        if (!empty($_GET['date_from']) && !empty($_GET['date_to'])) {
            $date_from = $_GET['date_from'];
            $date_to = $_GET['date_to'];

            $is_using_date = true;
        }

        # Get Product Codes
        $codes = PurchaseCodes::select(
            'product_purchase_codes.code',
            'product_purchase_codes.status',
            'product_purchase_codes.owner_id',
            'product_purchase_codes.product_type',
            'product_purchase_codes.created_at as date_created',
            'transfer_branch_histories.created_at as transferred',
            'branches.name as branch_name',
            'products.name as product_name',
            'users_a.username as owner_name',
            'users_b.username as generated_name'
        )
            ->leftJoin('transfer_branch_histories', function ($join) {
                $join->on('transfer_branch_histories.code', '=', 'product_purchase_codes.code');
                $join->on('transfer_branch_histories.current_branch', '=', 'product_purchase_codes.branch_id');
            })
            ->leftJoin('branches', 'branches.id', '=', 'transfer_branch_histories.current_branch')
            ->leftJoin('products', 'products.id', '=', 'product_purchase_codes.product_id')
            ->leftJoin('accounts', 'accounts.id', '=', 'product_purchase_codes.owner_id')
            ->leftJoin('users as users_a', 'users_a.id', '=', 'accounts.user_id')
            ->leftJoin('users as users_b', 'users_b.id', '=', 'product_purchase_codes.generated_by')
            ->where($codes_where_query)
            ->whereDate('product_purchase_codes.created_at', '>=', $date_from)
            ->whereDate('product_purchase_codes.created_at', '<=', $date_to)
            ->orderBy('product_purchase_codes.created_at', 'DESC')
            ->paginate(10);

        # Get Total, Available, Bought All
        $total_product_all = PurchaseCodes::selectRaw('count(id) as total, product_purchase_codes.status')
            ->where($total_product_all_where_query)
            ->whereDate('created_at', '>=', $date_from)
            ->whereDate('created_at', '<=', $date_to)
            ->groupBy('status')
            ->get();


        if ($product_name == '') {

            # Get Total, Available, and Bought Per Product
            $total_product_per = Products::select('products.name', 'products.id')->get();
            # Get i'ts numbers
            $total_product_per = $total_product_per->map(function ($item, $key) use ($total_product_per_where_query, $date_from, $date_to) {

                $product_id = $item->id;

                $query = $total_product_per_where_query;

                $query['product_id'] = $product_id;
                $total = PurchaseCodes::where($query)
                    ->whereDate('created_at', '>=', $date_from)
                    ->whereDate('created_at', '<=', $date_to)
                    ->count();

                $query['status'] = PurchaseCodes::STATUS_UNUSED;
                $untransferred_available = PurchaseCodes::where($query)
                    ->whereDate('created_at', '>=', $date_from)
                    ->whereDate('created_at', '<=', $date_to)
                    ->count();

                $query['status'] = PurchaseCodes::STATUS_TRANSFERED;
                $transferred_available = PurchaseCodes::where($query)
                    ->whereDate('created_at', '>=', $date_from)
                    ->whereDate('created_at', '<=', $date_to)
                    ->count();

                $query['status'] = PurchaseCodes::STATUS_USED;
                $transferred_bought = PurchaseCodes::where($query)
                    ->whereDate('created_at', '>=', $date_from)
                    ->whereDate('created_at', '<=', $date_to)
                    ->count();

                $item->total = $total;
                $item->untransferred_available = $untransferred_available;
                $item->transferred_available = $transferred_available;
                $item->bought = $transferred_bought;

                return $item;
            });
        }

        # Get All Branches
        $branches = Branches::select('id', 'name')->get();

        # Get All Products
        $products = Products::select('slug', 'name')->get();

        return view($this->viewpath . 'product_code_inventory')->with([
            # get params
            'coop_branch' => $branch,
            'product_name' => $product_name,
            'product_availability' => $availability,
            'date_from' => $date_from,
            'date_to' => $date_to,
            # for date
            'is_date' => $is_using_date,
            # select options
            'branches' => $branches,
            'products' => $products,
            # codes item
            'product_codes' => $codes,
            # all total inventory
            'total_product_all' => $total_product_all,
            'total_product_per' => $total_product_per,
        ]);
    }
    # Product Purchase Codes


    function getUnilevel($product_id = 0)
    {

        $products = Products::select('id', 'name')->get();

        return view($this->viewpath . 'unilevel')->with([
            'products' => $products
        ]);

        #    $type = $this->theCompany->product_unilevel;
        #
        #    $products = Products::all();
        #
        #    $settings = ($type == ' universal ') ? ProductUnilevel::orderBy(' level ', ' ASC ')->get() : ProductUnilevel::where(' product_id ', $product_id)->orderBy(' level ', ' ASC ')->get();
        #
        #    $nextLevel = 0;
        #
        #    foreach ($settings as $row) {
        #        $nextLevel = $row->level;
        #    }
        #    
        #    $nextLevel += 1;
        #    
        #    return view($this->viewpath . ' unilevel ')
        #        ->with([
        #            ' type ' => $type,
        #            ' settings ' => $settings,
        #            ' nextLevel ' => $nextLevel,
        #            ' products ' => $products
        #        ]);
    }

    # get Unilevel Product Limit ammount
    function getUnilevelProductLimit($id)
    {
        # 55 is the level where the total limit of the unilevel product is
        $limit_in_row = 555;
        $idd = $id . $limit_in_row;

        $ammount = ProductUnilevel::where('product_id', $idd)->pluck('amount');

        # check if there is an ammount
        if (!$ammount) {
            $request = new Request();
            $request->setMethod('POST');
            $request->request->add(['product_id' => $id, 'not_exist' => true]);

            $request_json = $this->postUnilevelProductNewLimit($request);

            $request_decode = json_decode($request_json->getContent());

            return $request_decode->ammount;
        }

        return $ammount;
    }


    # New function for setting unilevel amount
    # Set unilevel amount
    function postSetUnilevelAmount(Request $request)
    {

        $levels = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $product_id = $request->product_id;
        $product_level = $product_id . 555;

        $amount = $request->new_ammount;

        $product_unilevel = ProductUnilevel::firstOrCreate([
            'product_id' => $product_level,
            'level' => 1
        ]);

        $product_unilevel->amount = $amount;

        if ($product_unilevel->save()) {

            $amount_per_level = $amount / 9;

            $product_unilevels = ProductUnilevel::where('product_id', $product_id)
                ->orderBy('level', 'ASC')
                ->get();


            foreach ($levels as $level) {
                # code...
                $have_level = false;

                foreach ($product_unilevels as $uni) {
                    # code...
                    if ($level == $uni->level) {
                        $have_level = true;
                    }
                }

                if (!$have_level) {

                    # if not create new unilevel level

                    $new_level = new ProductUnilevel();

                    $new_level->product_id = $product_id;
                    $new_level->level = $level;
                    $new_level->amount = $amount_per_level;

                    if (!$new_level->save())
                        return response()->json(['status' => 'error', 'message' => 'Error Setting Unilevel ', 'error' => true], 400);
                }
            }

            foreach ($product_unilevels as $unilevel) {
                # code...

                $unilevel->amount = $amount_per_level;

                if (!$unilevel->save()) {
                    return response()->json(['status' => 'error', 'message' => 'Error Setting Unilevel ', 'error' => true], 400);
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Successfully Updated Unilevel Amount', 'error' => false, 'ammount' => $amount], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Error Setting Unilevel ', 'error' => true], 400);
    }


    # Comment function if necessary
    # function is useless 
    # on new unilevel set amount
    # function SetUnilevelAmount()
    # -------
    # POST Unilevel Product Limit
    # create new unilevel product limit in product_unilevel table if none exist
    #
    function postUnilevelProductNewLimit(Request $request)
    {
        $unilevel_total = 0;
        # id + 555 is the id where the total limit of the unilevel product is
        $level = 555;
        $product_id = $request->product_id;
        $product_total_id = $product_id . $level;
        # check if id 555 exist
        $not_exist = $request->not_exist;

        $new_ammount = $request->new_ammount;

        $new_ammount = ($new_ammount) ? $new_ammount : 10;

        # get sum of the total ammount of all rows with product_id
        $unilevel_total = ProductUnilevel::where('product_id', $product_id)->get()->sum('amount');

        # if not
        if ($not_exist) {
            # create new ProductUnilevel
            $total = new ProductUnilevel();

            $total->product_id = $product_total_id;
            $total->level = 1;
            $total->amount = $unilevel_total;

            # if save is unsuccessful
            if (!$total->save()) {
                return response()->json(['status' => 'error', 'message' => 'unable to save', 'error' => true], 400);
            }
        } else {

            # check if the input limit is lesser
            #if ($unilevel_total >= $new_ammount) {

            # get all unilevel products
            $unilevels = ProductUnilevel::where('product_id', $product_id)->get();

            foreach ($unilevels as $level) {
                # code...
                # set ammount to 0
                $level->amount = 0;

                $level->save();
            }

            #return response()->json(['status' => 'error', 'message' => 'New ammount greater than or equal to the unilevel product ammount!', 'error' => true], 400);
            #}

            # get the row where 
            # product_id = $product_id and level = 555
            $unilevel_total = ProductUnilevel::where('product_id', $product_total_id)->first();

            $unilevel_total->amount = $new_ammount;

            $unilevel_total->save();

            $unilevel_total = $unilevel_total->amount;
        }

        # return json success
        return response()->json(['status' => 'success', 'message' => 'Successfully Updated the total ammount', 'error' => false, 'ammount' => $unilevel_total], 200);
    }

    function postUnilevelList(Request $request)
    {
        # create array for list of levels
        $levels = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $new_level_inserted = false;

        $id = ($request->input('id')) ? $request->input('id') : 1;

        $unilevel_list = DB::table('product_unilevel')
            ->where('product_id', $id)
            ->where('product_id', '!=', $id + 555)
            ->orderBy('level', 'ASC')
            ->get();

        foreach ($levels as $level) {

            $have_level = false;

            foreach ($unilevel_list as $list) {
                # check if level exist in list
                if ($list->level == $level) {
                    $have_level = true;
                }
            }
            # if level exists continue loop
            if ($have_level)
                continue;
            # if not create new unilevel level
            $new_level = new ProductUnilevel();

            $new_level->product_id = $id;
            $new_level->level = $level;
            $new_level->amount = 0;

            if ($new_level->save())
                $new_level_inserted = true;
        }

        if ($new_level_inserted) {
            # get new list of unilevel
            $unilevel_list = DB::table('product_unilevel')
                ->where('product_id', $id)
                ->where('product_id', '!=', $id + 555)
                ->orderBy('level', 'ASC')
                ->get();
        }

        echo json_encode($unilevel_list);
    }

    function postNewList(Request $request)
    {
        $unilevel_list = DB::table('product_unilevel')
            ->where('product_id', $request->input('id'))
            ->get();
        echo json_encode($unilevel_list);
    }

    function postUpdateUnilevel(Request $request)
    {
        $id = $request->id;
        # id + 555 is the product id of the total
        $product_id = $request->product_id;
        $id_total = $product_id . 555;
        $ammount = $request->amount;

        $sum = ProductUnilevel::where('product_id', $product_id)->where('id', '!=', $id)->get()->sum('amount');
        $total_sum = ProductUnilevel::where('product_id', $id_total)->pluck('amount');

        if ($sum + $ammount > $total_sum)
            return response()->json(['status' => 'error', 'message' => 'Total ammount is greater than the set limit ammount', 'error' => true], 400);

        $input = ProductUnilevel::find($id);
        $input->amount = $ammount;

        if ($input->save()) {
            Session::flash('success', 'Amount updated !');
        } else {
            Session::flash('success', 'Failed to update !');
        }
        return response()->json(['status' => 'success', 'message' => 'Successfully Updated', 'error' => false], 200);
    }

    function postUnilevel(Request $request, $product_id = 0)
    {

        $result = new \stdClass();
        $result->error = false;
        $result->message = ' ';

        $type = $this->theCompany->product_unilevel;

        $settings = ($type == 'universal') ? ProductUnilevel::orderBy('level', 'ASC')->get() : ProductUnilevel::where('product_id', $product_id)->orderBy('level', 'ASC')->get();

        $nextLevel = 0;

        foreach ($settings as $row) {
            $nextLevel = $row->level;
        }

        $nextLevel += 1;

        if ($request->add_unilevel) {

            if ($request->amount == null) {
                $result->error = true;
                $result->message = Lang::get('products.amount_required');
            }

            if ($type == 'per_product' and $product_id <= 0) {
                $result->error = true;
                $result->message = Lang::get('products.product_required');
            }

            if (!$result->error) {

                $unilevel = new ProductUnilevel();
                $unilevel->amount = $request->amount;
                $unilevel->level = $nextLevel;
                $unilevel->product_id = $product_id;
                $unilevel->save();
                $result->message = Lang::get('products.settings_saved');
            }
        } else if ($request->update) {

            $id = $request->id;

            if ($request->amount[$id] == null) {
                $result->error = true;
                $result->message = Lang::get('products.amount_required');
            }

            if (!$result->error) {

                $unilevel = ProductUnilevel::find($id);
                $unilevel->amount = $request->amount[$id];
                $unilevel->level = $request->level[$id];
                $unilevel->product_id = $request->product_id[$id];
                $unilevel->save();
                $result->message = Lang::get('products.settings_saved');
            }
        }

        return ($result->error) ? redirect('admin/products/unilevel')->withInput()->with([
            'danger' => $result->message
        ]) : redirect('admin/products/unilevel')->with('success', $result->message);
    }

    function getDelete($id)
    {

        $purchased = Purchases::where('product_id', $id)->get();

        $error = false;
        $message = '';

        if ($purchased->isEmpty()) {

            Products::where('id', $id)->delete();
            PurchaseCodes::where('product_id', $id)->delete();
            ProductUnilevel::where('product_id', $id)->delete();
            $message = Lang::get('products.delete_success');
        } else {

            $message = Lang::get('products.cannot_delete');
            $error = true;
        }

        $message_type = ($error) ? 'danger' : 'success';

        return back()->with($message_type, $message);
    }

    # Reduntdant Binary
    # start of redundant binary
    # show redundant binary
    function getRedundantBinarySettings()
    {

        $redundant_binary_settings = ProductPointsEquivalent::select('points_value', 'points_equivalent', 'up_to_level')->first();

        $products = Products::select('products.id', 'products.name', 'products.points_value', 'products.image')->orderBy('created_at', 'DESC')->paginate(15);

        return view($this->viewpath . 'redundant_binary_settings')->with([
            'products' => $products,
            'redundant_settings' => $redundant_binary_settings
        ]);
    }


    # get method reqeust for updating product points
    function getRedundantBinaryUpdateProductPoints(Request $request)
    {
        $id = $request->product_id;
        $points_value = $request->points_value;

        $points_value = ($points_value) ? $points_value : 0;

        if ($id && $points_value >= 0 && $points_value <= 10000) {

            $product = Products::where('id', $id)->first();

            $product->points_value = $points_value;

            if ($product->save()) {
                return response()->json(['status' => 'alert-success', 'message' => 'Successfully Updated'], 200);
            }
        }

        return response()->json(['status' => 'alert-danger', 'message' => 'Unsuccessful Update'], 400);
    }

    function postRedundantBinarySettingsUpdate(Request $request)
    {
        $points_value = $request->points_value;
        $points_equivalent = $request->points_equivalent;
        $level = $request->redundant_binary_level;

        $status = '';
        $message = '';

        if ($points_value < 0 || $points_equivalent < 0) {
            $status = 'alert-danger';
            $message = 'Unsuccessful Update of Points';
        } else {

            $product_points = ProductPointsEquivalent::first();

            $product_points->points_value = $points_value;
            $product_points->points_equivalent = $points_equivalent;
            $product_points->up_to_level = $level;

            if ($product_points->save()) {
                $status = 'alert-success';
                $message = 'Successful Update of Points';
            } else {
                $status = 'alert-danger';
                $message = 'Unsuccessful Update of Points';
            }
        }

        return redirect('/admin/products/redundant-binary-settings')->with([
            'update_status' => $status,
            'update_message' => $message
        ]);
    }

    # Update Enable or Disable Product for Redundant Binary
    function postEnDisabled(Request $request)
    {
        $product_id = $request->product_id;

        $endis_type = $request->type;

        $type = '';

        # check if the endis_type variable is 0 or -1
        # if 0 type will be enable
        # if -1 type will be disable
        if ($endis_type == 0) {
            $endis_type = -1;
            $type = 'Disabled';
        } else if ($endis_type == -1) {
            $endis_type = 0;
            $type = 'Enabled';
        }

        $status = 'error';
        $message = 'Unable to ' . $type . ' Product';
        $status_code = 400;

        $product = Products::select('points_value', 'id', 'name', 'rebates', 'price', 'global_pool')->where('id', $product_id)->first();

        if ($product) {

            $product->points_value = $endis_type;

            if ($product->save()) {
                $status = 'success';
                $message = 'Successfully ' . $type . ' Product';
                $status_code = 200;
            }
        }

        return response()->json(['status' => $status, 'message' => $message], $status_code);
    }

    # Update Enable or Disable Product for Redundant Binary
    // function getDiss(Request $request)
    // {


    //     $product = Products::select()->where('id', 6)->first();

    //     $product->points_value = '123';

    //     $product->save();

    //     dd($product);
    // }


    /**
     * Products 
     * Products Related Functions
     * @url '/admin/products/*
     */

    function postTransferProducts(Request $request)
    {
        $product = $request->transfer_product;
        $price_type = $request->transfer_price_type;
        $branch = $request->transfer_branch;
        $quantity = $request->transfer_quantity;

        $message = [
            'transfer_branch.required' => 'Please Select a Branch to Transfer Product Code',
            'transfer_quantity.required' => 'Number of Product Codes to Transfer is Required',
            'transfer_quantity.numeric' => 'Number of Product Codes to Transfer must be numeric',
            'transfer_quantity.min' => 'Number of Product Codes to Transfer must be 1 or more',
            'transfer_quantity.max' => 'Number of Product Codes to Transfer must be less than 10,000'
        ];

        $this->validate($request, [
            'transfer_branch' => 'required',
            'transfer_quantity' => 'required|numeric|min:1|max:10000'

        ], $message);

        $params = [];
        $params['status'] = PurchaseCodes::STATUS_UNUSED;

        if ($product)
            $params['product_id'] = $product;

        if ($price_type)
            $params['product_type'] = $price_type;

        $product_codes = PurchaseCodes::select(
            'id',
            'status',
            'product_id',
            'product_type',
            'branch_id',
            'code',
            'password'
        )
            ->where($params)->take($quantity)->get();



        if (!$product_codes->isEmpty()) {

            $total = 0;

            $branch_name = Branches::where('id', $branch)->pluck('name');

            foreach ($product_codes as $codes) {

                # code...
                $codes->status = PurchaseCodes::STATUS_TRANSFERED;
                $codes->branch_id = $branch;

                if ($codes->save()) {

                    # create instance of Transfer Branch History
                    $history = new TransferBranchHistory();

                    # assign code to unique code
                    $history->code = $codes->code;

                    # assing current branch to the inputted current branch
                    $history->current_branch = $branch;

                    # query to the database for
                    # for getting the last branch
                    $last_branch = TransferBranchHistory::where('code', '=', $codes->code)->orderBy('id', 'DESC')->first();

                    # check if last branch has value 
                    # assign default value if empty
                    $last_branch = (!$last_branch) ? 0 : $last_branch;

                    # assign last branch coloum
                    $history->last_branch = $last_branch;

                    # save history
                    $history->save();

                    $total++;
                }
            }

            $message = "Successfully Transferred " . $total . " of " . $quantity . " Product Codes to " . $branch_name;

            return redirect()->back()->with([
                'transfer_success' => $message
            ]);
        } else {
            $error['transfer_error'] = 'No Product Codes Available';

            return redirect()->back()->withErrors($error);
        }
    }

    /**
     * Redundant Binary History
     * 
     * @param Illuminate\Http\Request;
     */
    public function getRedundantBinaryHistory(Request $request)
    {

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $use_date = $date_to;

        $use_date = date('Y-m-d', strtotime($date_to . "+1 days"));

        $name = $request->name;
        $type = $request->type;

        $per_page = 50;

        $history = AccountRedudantPointsHistory::select('account_redudant_points_histories.*');

        $account_id = null;

        if (!$date_from) {
            $date_from = '2018-01-01';
        }

        if (!$date_to) {
            $date_to = Carbon::now()->format('Y-m-d');

            $use_date = date('Y-m-d', strtotime($date_to . "+1 days"));
        }

        if ($name) {

            $user_id = User::where('username', 'LIKE', '%' . $name . '%')->pluck('id');

            $acc_id = Accounts::where('user_id', $user_id)->pluck('id');

            if ($acc_id) {
                $account_id = $acc_id;
            } else {
                $account_id = -1;
            }
        }

        if ($account_id) {
            $history->leftJoin('account_redudant_points', 'account_redudant_points.id', '=', 'account_redudant_points_histories.account_redundant_points_id');

            $history->orWhere('purchase_account_id', $account_id);
            $history->orWhere('account_redudant_points.account_id', $account_id);
        }

        if ($type) {
            $history->where('type', $type);
        }

        $history->whereBetween('account_redudant_points_histories.created_at', [$date_from, $use_date]);

        $history = $history->paginate($per_page);

        return view($this->viewpath . 'redundant_binary_history')->with([
            'date_from' => $date_from,
            'date_to' => $date_to,
            'type' => $type,
            'history' => $history
        ]);
    }
}
