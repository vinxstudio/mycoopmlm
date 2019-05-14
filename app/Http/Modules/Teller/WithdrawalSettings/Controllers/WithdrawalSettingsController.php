<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/4/17
 * Time: 2:53 PM
 */

namespace App\Http\Modules\Admin\WithdrawalSettings\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\WithdrawalSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WithdrawalSettingsController extends AdminAbstract{

    protected $viewpath = 'Admin.WithdrawalSettings.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){

        $settings = WithdrawalSettings::find(1);
        return view( $this->viewpath . 'index' )
            ->with([
                'settings'=>$settings
            ]);

    }

    function postIndex(Request $request){

        $rules = [
            'minimum_amount'=>'required|numeric',
            'admin_fee'=>'required|numeric',
            'tax'=>'required|numeric'
        ];

        $validate = Validator::make($request->input(), $rules);

        $error = false;

        if (!$validate->fails()){

            DB::beginTransaction();
            try{
                $settings = WithdrawalSettings::find(1);
                $settings->minimum_amount = $request->minimum_amount;
                $settings->admin_charge = $request->admin_fee;
                $settings->tax_percentage = $request->tax;
                $settings->save();
                DB::commit();
                Session::flash('success', Lang::get('withdrawal.settings_saved'));
            } catch (\Exception $e){
                $error = true;
                Session::flash('danger', $this->formatException($e));
            }
        } else {
            $error = true;
        }

        return ($error) ? redirect('admin/withdrawal-settings')->withErrors($validate->errors())->withInput() : redirect('admin/withdrawal-settings');

    }

}