<?php namespace App\Http\Modules\Admin\ActivationCodes\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\Modules\Admin\ActivationCodes\Validation\ActivationCodeValidationHandler;
use App\Http\Requests;
use App\Models\ActivationCodeBatches;
use App\Models\ActivationCodes;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class ActivationCodeAdminController extends AdminAbstract {

    protected $viewpath = 'Admin.ActivationCodes.views.';
    function __construct(){
        parent::__construct();
    }

    function getIndex($date_from = null, $date_to = null){
        //$membership = Membership::find(0);
        
        $q = ActivationCodes::select('user_details.first_name', 'user_details.last_name',
                                    'activation_codes.*', 'branches.name','users.username')
                                ->leftJoin('users', 'users.id', '=', 'activation_codes.teller_id')
                                ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                                ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                                ->where('activation_codes.id', '!=', 0);

        if(!empty($date_from)) $q->where('activation_codes.created_at', '>=', $date_from);
        if(!empty($date_to)) $q->where('activation_codes.created_at', '<=', $date_to);
        
        $codes = $q->paginate(50);
       
        return view($this->viewpath.'code-list')
            ->with(
                [
                    // 'batches'=>ActivationCodeBatches::paginate(50),
                    'codes'=>$codes,
					'membership'=>Membership::where('id', '<=', 6)->get(),
                    'date_from'=>$date_from,
                    'date_to'=>$date_to
                ]
            );
    }

    function postIndex(Request $request){
        
        if(!empty($request->input('date_range')) ) {
            return redirect('/admin/activation-codes/index/'.$request->input('date_from').'/'.$request->input('date_to'));
            // $date_from = (!empty($request->input('date_from')))? $request->input('date_from') : '';
            // $date_to = (!empty($request->input('date_to')))? $request->input('date_to') : '';

            // $q = ActivationCodes::select('user_details.first_name', 'user_details.last_name',
            //                         'activation_codes.*')
            //                     ->leftJoin('users', 'users.id', '=', 'activation_codes.teller_id')
            //                     ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
            //                     ->leftJoin('user_details', 'user_details.id', '=', 'users.id')
            //                     ->where('activation_codes.id', '!=', 0);

            // if(!empty($date_from)) $q->where('activation_codes.created_at', '>=', $date_from);
            // if(!empty($date_to)) $q->where('activation_codes.created_at', '<=', $date_to);
            
            // $codes = $q->paginate(50);
  
            // return view($this->viewpath.'code-list')
            //     ->with(
            //         [
            //             // 'batches'=>$batches,
            //             'codes'=> $codes,
            //             'membership'=>Membership::paginate(50),
            //             'date_from'=>$date_from,
            //             'date_to'=>$date_to
            //         ]
            //     );
        }else{
            $codeValidator = new ActivationCodeValidationHandler();
            $codeValidator->setTellerId($this->theUser->id);
            $codeValidator->setInputs($request->input());
            $result = $codeValidator->validate();

            Session::flash($result->message_type, $result->message);

            return ($result->error) ? redirect('admin/activation-codes')->withErrors($result->validation->errors())->withInput() : redirect('admin/activation-codes/view-batch/'.$result->batch_id);
        }

    }

    function getViewBatch($id = null){
        return view($this->viewpath.'view-codes')->with(
            [   'codes' => ActivationCodes::select('user_details.first_name', 'user_details.last_name',
                                    'activation_codes.*')
                                ->leftJoin('users', 'users.id', '=', 'activation_codes.teller_id')
                                ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                                ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                                ->where('batch_id', $id)
                                ->paginate(50)
            
            ]
        );
    }

    function postDeleteCode(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'activation_id' => 'required',
            'delete_reason' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json(['errors' => "Reason field is required!"]);
        }
        
        $code = ActivationCodes::where('id', $id)
                        ->update([
                            'status' => 'deleted',
                            'reason' => $request->input('delete_reason')
                        ]);
        if($code)
        {
            return response()->json(['message' => "Success!"]);
        }

    }

    function getReason($id)
    {   
        $code = ActivationCodes::select('reason')->where('id', $id)->first();
        
        if($code)
        {
            return response()->json($code);
        }
    }

    function exportFile($type, $date_from=null, $date_to=null ){

            $date_from = (!empty($date_from))? $date_from : '';
            $date_to = (!empty($date_to))? $date_to : '';

            $q = ActivationCodes::select('user_details.first_name', 'user_details.last_name',
                                    'activation_codes.*','branches.name','users.username')
                                ->leftJoin('users', 'users.id', '=', 'activation_codes.teller_id')
                                ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                                ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                                ->where('activation_codes.id', '!=', 0);

            if(!empty($date_from)) $q->where('activation_codes.created_at', '>=', $date_from);
            if(!empty($date_to)) $q->where('activation_codes.created_at', '<=', $date_to);
            
            $codes = $q->get();
  
        return \Excel::create('Activation_Code', function($excel) use($codes) {

            $excel->sheet('Activation_Code', function($sheet) use(&$codes)
            {
                $sheet->loadView($this->viewpath . 'code_list_excel' )
                    ->withCodes($codes);
            });

        })->download($type);

    }
}
