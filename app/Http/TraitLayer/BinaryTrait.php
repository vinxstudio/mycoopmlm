<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/3/17
 * Time: 10:49 PM
 */

namespace App\Http\TraitLayer;

use App\Helpers\Binary;
use App\Models\Accounts;
use App\Models\ActivationCodes;
use App\Models\Company;
use App\Models\CompanyEarnings;
use App\Models\Details;
use App\Models\Earnings;
use App\Models\EWallet;
use App\Models\MoneyPot;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

trait BinaryTrait{

    use GlobalSettingsTrait;

    protected $result,
        $userObject = null,
        $activation_code_id = 0,
        $upline_id = 0,
        $sponsor_id = 0
    ;

    private function calculateCompanyBaseIncome(){
        $result = new \stdClass();
        $company = Company::find($this->companyID);

        $result->referral_income = $company->referral_income;
        $result->money_pot = $company->money_pot;
        $result->company_income = $company->entry_fee - ($company->referral_income + $company->money_pot);
        return $result;
    }

    function setUserObject($object){
        $this->userObject = $object;
        return $this;
    }

    function setActivationCodeId($id){
        $this->activation_code_id = $id;
        return $this;
    }

    function setUplineId($id){
        $this->upline_id = $id;
        return $this;
    }

    function setSponsorId($id){
        $this->sponsor_id = $id;
        return $this;
    }

    function validateAdminRegistration($request){
        $this->result = new \stdClass();
        $this->result->error = false;
        $this->result->message_type = '';
        $this->result->message = '';

        $activation_id = ($this->activation_code_id > 0) ? $this->activation_code_id : $request->activation_code;
        $upline_id = ($this->upline_id > 0) ? $this->upline_id : $request->upline;
        $sponsor_id = ($this->sponsor_id > 0) ? $this->sponsor_id : $request->sponsor;

        $activationCode = ActivationCodes::find($activation_id);
        $company = Company::find($this->companyID);

        $upline = Accounts::find($upline_id);

        $sponsor = ($sponsor_id > 0) ? Accounts::find($sponsor_id) : null;

        $sponsor_id = (isset($sponsor->id) and $sponsor->id > 0) ? $sponsor->id : 0;

        if (!isset($activationCode->id)) {

            $this->result->message_type = 'danger';

            $this->result->message = Lang::get('messages.invalid_activation_code');

            $this->result->error = true;

        } else if (!isset($upline->id)){

            $this->result->message_type = 'danger';

            $this->result->message = Lang::get('messages.invalid_upline');

            $this->result->error = true;

        } else {

            if ($activationCode->status == 'used') {

                $this->result->message_type = 'danger';

                $this->result->message = Lang::get('messages.invalid_activation_code');

                $this->result->error = true;

            } else {

                $downline_count = Accounts::where('upline_id', $upline->id)->get();

                $proceed = true;

                if ($downline_count->count() >= 2) {

                    $this->result->message_type = 'danger';

                    $this->result->message = Lang::get('messages.upline_has_complete_nodes');

                    $this->result->error = true;

                    $proceed = false;

                } elseif(Accounts::where('node', $request->node_placement)->where('upline_id', $upline->id)->count() > 0 ){

                    $this->result->message_type = 'danger';

                    $this->result->message = Lang::get('messages.node_already_occupied');

                    $this->result->error = true;

                    $proceed = false;

                }

                if ($proceed){
                    DB::beginTransaction();
                    try {
                        $node = $request->node_placement;
                        $companyIncome = $this->calculateCompanyBaseIncome();

                        if ($this->userObject != null){
                            $user = $this->userObject;
                        } else {
                            $details = new Details();
                            $details->first_name = $request->first_name;
                            $details->last_name = $request->last_name;
                            $details->email = $request->email;
                            $details->bank_name = $request->bank_name;
                            $details->account_name = $request->bank_account_name;
                            $details->account_number = $request->bank_account_number;
                            $details->save();

                            $user = new User();
                            $user->username = $request->username;
                            $user->password = Hash::make($request->password);
                            $user->user_details_id = $details->id;
                            $user->paid = TRUE_STATUS;
                            $user->save();
                        }

                        $account = new Accounts();
                        $account->user_id = $user->id;
                        $account->code_id = $activationCode->id;
                        $account->upline_id = $upline->id;
                        $account->sponsor_id = $sponsor_id;
                        $account->node = $request->node_placement;
                        $account->save();

                        $binary = new Binary();
                        $pairing = $binary
                            ->setMemberObject($account)
                            ->crawl();

                        $binary->runReferral($pairing, $companyIncome, $sponsor_id, $sponsor, $activationCode, $user->id);

                        $code = ActivationCodes::find($activationCode->id);
                        $code->status = 'used';
                        $code->save();

                        $this->result->message_type = 'success';

                        $this->result->message = Lang::get('messages.success_register');
                        DB::commit();
                    } catch (\Exception $e){

                        $this->result->error = true;
                        $this->result->message_type = 'danger';
                        $this->result->message = sprintf('%s on line %s on file %s', $e->getMessage(), $e->getLine(), $e->getFile());
                        DB::rollback();

                    }
                }


            }
        }

        return $this->result;

    }

}