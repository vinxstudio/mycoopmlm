<?php namespace App\Http\Modules\Admin\Company\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\Modules\Admin\Company\Validation\CompanyValidationHandler;
use App\Http\Requests;
use App\Models\Company;
use App\Models\CompanyBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompanyAdminController extends AdminAbstract {

    protected $viewpath = 'Admin.Company.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        return view($this->viewpath.'index')
            ->with(
                [
                    'company'=>Company::find(1),
                    'bank'=>CompanyBank::find(1)
                ]
            );
    }

    function postIndex(Request $request){

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
        } else if ($request->save_bank){
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

    function getSettings(){
        return view( $this->viewpath . 'paypal_settings' );
    }

    function postSettings(Request $request){
        $paypalConfig = 'config/paypal.php';
        $paypal = readConfig($paypalConfig);

        $paypal['username'] = $request->paypalUsername;
        $paypal['password'] = $request->paypalPassword;
        $paypal['signature'] = $request->paypalSignature;
        $paypal['sandbox'] = $request->paypalSandbox;

        updateConfig($paypalConfig, $paypal);

        return redirect('admin/paypal/settings')->with([
            'success'=>'PayPal Details are now updated'
        ]);
    }

}
