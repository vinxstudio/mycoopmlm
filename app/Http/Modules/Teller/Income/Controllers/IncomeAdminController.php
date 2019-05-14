<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/3/17
 * Time: 11:35 PM
 */

namespace App\Http\Modules\Admin\Income\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Company;
use App\Models\Membership;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class IncomeAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.Income.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
		$membership = Membership::find(1);
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
        $company = Company::find(1);
		
		
        if($request->save_entry_fee){

            DB::beginTransaction();
            try {
				/*
                $company->money_pot = $request->money_pot_amount;
                $company->entry_fee = $request->entry_fee;
                $company->save();
                $result->message = Lang::get('messages.saved');
				*/
				/*foreach( $request as $key => $n ) {
					$membership1->money_pot = $request->money_pot_amount;
					$membership1->entry_fee = $request->entry_fee;
					$membership1->save();
					$result->message = Lang::get('messages.saved');
				*/
				//$input = $request->input('products.0.package_name');
				//$i = 0;
				//$packagename = $request->input('package_name.'.$i);
				//for ($packagename != NULL) {
				//	$request->input('package_name.'.$i);
				//}
				//$i = 1;
				//$request['items']->each(function($item, $key) use ($order) {
					 //if (!empty($item['package_name'])) {
				$key = 1;
				$ctr = 0;
				while ($ctr < 3){
						$membership1 = Membership::find($key);
						//$updateItem = Membership::find($item['id']);
						//Input::get("name.0")
						$membership1->membership_type_name = $request->input('package_name.'.$ctr);
						$membership1->membership_description = $request->input('package_description.'.$ctr);
						$membership1->money_pot = $request->input('money_pot.'.$ctr);
						$membership1->entry_fee = $request->input('entry_fee.'.$ctr);
						$membership1->save();
						
					//}
					$ctr++;
					$key++;
				//});
				}
                DB::commit();
				
            } catch (\Exception $e) {
                DB::rollback();
                $result->error = true;
                $result->message = $this->formatException($e);

                if ($e instanceof QueryException) {
                    $result->message = Lang::get('messages.generic_error');
                }
            }


        } else if ($request->save_maintenance){
            $company->minimum_product_purchase = $request->minimum_purchase;
            $company->save();
            $result->message = Lang::get('messages.saved');

        }
        return ($result->error) ? redirect('admin/income')->with('danger', $result->message) : redirect('admin/income')->with('success', $result->message);

    }

}