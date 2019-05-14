<?php

namespace App\Http\Modules\Admin\Pairing\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Company;
use App\Models\PairingSettings;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class PairingAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.Pairing.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        return view( $this->viewpath . 'index' )->with(
                [
                    'membership'=>Membership::paginate(50)
                ]
        );
    }

    function postIndex(Request $request){

        $result = new \stdClass();
        $result->error = false;
        $result->message = '';

        $company = $this->theCompany;

        $validation = Validator::make([], []);

        if($request->save_settings){
/*
            $validation = Validator::make($request->input(), [
                'max_pair'=>'numeric',
                'referral_income'=>'numeric',
                'pairing_income'=>'required|numeric'
            ]);*/


            if ($validation->fails()) {
                $result->error = true;
            } else {
                DB::beginTransaction();
                try {
					$key = 1;
					$ctr = 0;
					while ($ctr < 3){
						$membership1 = Membership::find($key);
						//$updateItem = Membership::find($item['id']);
						//Input::get("name.0")
						$membership1->pairing_income = $request->input('pairing_income.'.$ctr);
						$membership1->referral_income = $request->input('referral_income.'.$ctr);
						$membership1->points_value = $request->input('points_value.'.$ctr);
						$membership1->max_pairing =  $request->input('max_pairing.'.$ctr);
						$membership1->save();
						$ctr++;
						$key++;
					}
                	
					$company->first_start_time = $request->first_start_time;
					$company->first_cut_off_time = $request->first_cut_off_time;
					$company->second_start_time = $request->second_start_time;
					$company->second_cut_off_time = $request->second_cut_off_time;
				   
				   
                    $company->enable_flush_out = $request->flush_out;
                   
                  //  $company->pairing = $request->pairing_income;
                    $company->save();
                    $result->message = Lang::get('pairing.settings_saved');
                    DB::commit();

                } catch (\Exception $e) {
                    DB::rollback();
                    $result->error = true;
                    $result->message = $this->formatException($e);
                }
            }


        } else if($request->save_money_pot){

            DB::beginTransaction();
            try {
                $company = Company::find(1);
                $company->money_pot = $request->money_pot_amount;
                $company->save();
                $result->message = Lang::get('pairing.money_pot_saved');
                DB::commit();
            } catch (\Exception $e){
                DB::rollback();
                $result->error = true;
                $result->message = $this->formatException($e);
            }

        }

        return ($result->error) ? redirect('admin/pairing')->with('danger', $result->message)->withErrors($validation->errors()) : redirect('admin/pairing')->with('success', $result->message);

    }

}