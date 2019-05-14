<?php namespace App\Http\Modules\Admin\Company\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\Modules\Admin\Company\Validation\CompanyValidationHandler;
use App\Http\Requests;
use App\Models\Company;
use App\Models\CompanyBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Branches;
use App\Models\UserDetails;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyAdminController extends AdminAbstract
{

    protected $viewpath = 'Admin.Company.views.';

    function __construct()
    {
        parent::__construct();
    }

    function getIndex()
    {
        return view($this->viewpath . 'index')
            ->with(
                [
                    'company' => Company::find(1),
                    'bank' => CompanyBank::find(1)
                ]
            );
    }

    function postIndex(Request $request)
    {

        if ($request->save_details) {
            $validate = new CompanyValidationHandler();
            $validate->setInputs($request->input());

            $validate->setRules([
                'companyName' => 'required',
                'phone' => 'required',
                'programName' => 'required',
                'address' => 'required'
            ]);

            $result = $validate->validate();
        } else if ($request->save_bank) {
            $bank = CompanyBank::find(1);
            $bank->bank_name = $request->bankName;
            $bank->account_name = $request->bankAccountName;
            $bank->account_number = $request->bankAccountNumber;
            $bank->notes = $request->notes;
            $bank->save();

            $config = 'config/money.php';
            $existing = readConfig($config);
            $existing['currency'] = $request->currency;
            $existing['currency_symbol'] = $this->currencies[$request->currency];
            updateConfig($config, $existing);

            $result = new \stdClass();
            $result->error = false;
            $result->message_type = 'success';
            $result->message = 'Bank Details updated.';
        }

        Session::flash($result->message_type, $result->message);
        return ($result->error) ? redirect('admin/company')->withErrors($result->validation->errors())->withInput() : redirect('admin/company');
    }

    function getSettings()
    {
        return view($this->viewpath . 'paypal_settings');
    }

    function postSettings(Request $request)
    {
        $paypalConfig = 'config/paypal.php';
        $paypal = readConfig($paypalConfig);

        $paypal['username'] = $request->paypalUsername;
        $paypal['password'] = $request->paypalPassword;
        $paypal['signature'] = $request->paypalSignature;
        $paypal['sandbox'] = $request->paypalSandbox;

        updateConfig($paypalConfig, $paypal);

        return redirect('admin/paypal/settings')->with([
            'success' => 'PayPal Details are now updated'
        ]);
    }

    /*
     *
     * Branch
     * Teller
     * Admin
     * 
     */
    function getBranchTeller()
    {
        $branches = Branches::select('id', 'name')->get();

        return view($this->viewpath . 'branch_teller')->with([
            'branches' => $branches
        ]);
    }

    /* 
     * post route for adding new branch
     * post parameters
     * 
     */
    function postNewBranch(Request $request)
    {
        $message = [
            'required_if' => 'Phone number is required if both is blank',
            'regex' => 'Phone number is invalid'
        ];

        $this->validate($request, [
            'branch_name' => 'required',
            'branch_address' => 'required',
            'branch_phone_one' => 'regex:/^[0-9-]+$/|required_if:branch_phone_two,',
            'branch_phone_two' => 'regex:/^[0-9-]+$/'
        ], $message);


        $branch_name = $request->branch_name;
        $branch_address = $request->branch_address;
        $branch_type = $request->branch_type;
        $branch_number = '';

        $first_number = $request->branch_phone_one;
        $second_number = $request->branch_phone_two;

        if ($branch_type == 'not_main')
            $branch_type = 1;
        else if ($branch_type == 'main')
            $branch_type = 0;

        if ($first_number != '')
            $branch_number = $first_number . '; ' . $second_number;
        else if ($second_number != '')
            $branch_name = $second_number . '; ' . $first_number;

        $branch = new Branches();

        $branch->name = $branch_name;
        $branch->address = $branch_address;
        $branch->phone = $branch_number;
        $branch->main_branch = $branch_type;

        if (!$branch->save()) {
            $status = 'error';
            $message = 'Unable to add new branch';
            return redirect()->back()->with([
                'status' => $status,
                'message' => $message
            ])->withInput();
        }

        $status = 'success';
        $message = 'Successfully added branch';

        return redirect()->back()->with([
            'status' => $status,
            'message' => $message
        ]);


    }

    /*
     *
     * Teller
     * Add new Teller
     * POST
     * 
     */
    function postNewTeller(Request $request)
    {

        $message = [
            'image' => 'The uploaded file must me an image',
            'teller_image.max' => 'The image must me below 2mb'
        ];

        $this->validate($request, [
            'teller_first_name' => 'required|max:255',
            'teller_last_name' => 'required|max:255',
            'teller_username' => 'required|unique:users,username',
            'teller_password' => 'required|min:6|max:18|confirmed',
            'teller_email' => 'required|email',
            'teller_branch' => 'required',
            'teller_image' => 'image|max:2046'
        ], $message);

        $status = 'error';
        $message = 'Error in adding new teller';


        # User Details
        $first_name = $request->teller_first_name;
        $middle_name = $request->teller_middle_name;
        $last_name = $request->teller_last_name;
        $email = $request->teller_email;
        $bank_name = $request->teller_bank_name;
        $account_name = $request->teller_account_name;
        $account_number = $request->teller_account_number;
        $image = null;
        # User 
        # Users Table
        $username = $request->teller_username;
        $password = Hash::make($request->teller_password);
        $user_details_id = null;
        $role = 'teller';
        #
        # default member
        # True
        # False
        # don't know if its suppose to be true of false
        # i just set it to false
        $default_member = 'false';
        #
        # is maintained
        # all teller is true
        # checked in database
        $is_maintained = true;
        $remember_token = null;
        $verification_code = null;
        $paid = true;
        $needs_activation = 'false';
        # 
        # level
        # the level in the database varies
        # but, most of the teller level are 4
        # so i just set it to 4
        $level = 4;
        #
        # member_type_id
        # member type id of teller is 1
        $member_type_id = 1;
        $branch = $request->teller_branch;
        $group_id = null;


        if ($request->hasFile('teller_image')) {

            $filename = rand(10, 20);

            $file_extension = $request->file('teller_image')->getClientOriginalExtension();

            $image = $request->file('teller_image')->move('public/teller_image/', $request->file('teller_image') . '.' . $file_extension);
        }

        $user_details = new UserDetails();

        $user_details->photo = $image;
        $user_details->coop_id = null;
        $user_details->first_name = $first_name;
        $user_details->middle_name = $middle_name;
        $user_details->last_name = $last_name;
        $user_details->email = $email;
        $user_details->bank_name = $bank_name;
        $user_details->account_name = $account_name;
        $user_details->account_number = $account_number;


        if ($user_details->save()) {

            $user_details_id = $user_details->id;

            $user = new User();

            $user->username = $username;
            $user->password = $password;
            $user->user_details_id = $user_details_id;
            $user->role = $role;
            $user->default_member = $default_member;
            $user->is_maintained = $is_maintained;
            $user->remember_token = $remember_token;
            $user->verification_code = $verification_code;
            $user->paid = $paid;
            $user->needs_activation = $needs_activation;
            $user->level = $level;
            $user->member_type_id = $member_type_id;
            $user->branch_id = $branch;

            if ($user->save()) {

                $user->group_id = $user->id;

                if ($user->save()) {

                    $status = 'success';
                    $message = 'Successfully created new teller';

                } else {
                    $user->remove();
                    $user_details->remove();
                }

            } else {
                $user_details->remove();
            }



        }

        if ($status == 'error') {
            return redirect()->back()->with([
                'teller_status' => $status,
                'teller_message' => $message
            ])->withInput();
        }

        return redirect()->back()->with([
            'teller_status' => $status,
            'teller_message' => $message
        ]);



    }

}
