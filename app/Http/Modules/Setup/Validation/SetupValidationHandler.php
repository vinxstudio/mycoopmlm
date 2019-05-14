<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/22/16
 * Time: 10:42 AM
 */

namespace App\Http\Modules\Setup\Validation;

use App\Helpers\ModelHelper;
use App\Http\AbstractHandlers\MainValidationHandler;
use App\Models\Branches;
use App\Models\Company;
use App\Models\Details;
use App\Models\Membership;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SetupValidationHandler extends MainValidationHandler{

    function __construct(){
        parent::__construct();
    }

    function validate(){
        $inputs = $this->getInputs();
        try {

            if (isset($inputs['authenticate'])){

                $password = $inputs['password'];

                $company = Company::find(1);

                if (Hash::check($password, $company->setup_password)) {
                    session(
                        [
                            'authenticated' => true
                        ]
                    );
                } else {
                    $this->result->error = true;

                    $this->result->message = 'Invalid Password.';
                }

            } else if (isset($inputs['save-details'])) {

                $rules = [
                    'firstName'=>'required',
                    'lastName'=>'required',
                    'username'=>'required|unique:users|min:8',
                    'password'=>'required|min:8',
                    'companyName'=>'required',
                    'phone'=>'required',
                    'address'=>'required',
                    'businessName'=>'required',
                    'entryFee'=>'required|numeric',
                ];

                $handle = $this->handle($inputs, $rules);

                if (!$handle->error){

                    $membership = [
                        'id'=>1,
                        'entry_fee'=>$inputs['entryFee'],
                        'global_pool'=>$inputs['globalPool'],
                        'enable_voucher'=>isset($inputs['enable_voucher']) ? 'true' : 'false',
                        'max_pairing'=>$inputs['maxPair']
                    ];

                    $company = [
                        'id'=>1,
                        'app_name'=>$inputs['businessName'],
                        'name'=>$inputs['companyName'],
                        'phone'=>$inputs['phone'],
                        'address'=>$inputs['address'],
                        'first_time'=>'false',
                        'activation_code_prefix'=>getInitials($inputs['businessName']),
                        'product_code_prefix'=>getInitials($inputs['businessName'] . ' Products')
                    ];

                    $user = [
                        'first_name'=>$inputs['firstName'],
                        'last_name'=>$inputs['lastName']
                    ];

                    $auth = [
                        'username'=>$inputs['username'],
                        'password'=>Hash::make($inputs['password']),
                        'role'=>'admin'
                    ];

                    $modelHelper = new ModelHelper();

                    $userDetails = $modelHelper->manageModelData(new Details, $user);

                    $auth['user_details_id'] = $userDetails->id;

                    $company['main_admin_id'] = $userDetails->id;

                    $authDetails = $modelHelper->manageModelData(new User, $auth);

                    $membershipModel = $modelHelper->setPrimaryKey('id')->manageModelData(new Membership, $membership);

                    $companyModel = $modelHelper->setPrimaryKey('id')->manageModelData(new Company, $company);

                    $branch = $modelHelper->manageModelData(new Branches, [
                        'name'=>$companyModel->name,
                        'address'=>$companyModel->address,
                        'phone'=>$companyModel->phone,
                        'main_branch'=>'0'
                    ]);

                    $this->result->proceedToLogin = true;

                }

            }

        } catch (Exception $e){
            $this->result->error = true;

            $this->result->message = $e->getMessage();
        }

        if ($this->result->error){
            $this->result->message_type = 'danger';
        }
        return $this->result;
    }

}