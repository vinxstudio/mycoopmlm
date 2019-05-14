<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/12/17
 * Time: 9:22 PM
 */

namespace App\Http\Modules\Admin\Connect\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Company;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class ConnectAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.Connect.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        return view( $this->viewpath . 'index' )
            ->with([
                'connections'=>Connection::paginate($this->records_per_page)
            ]);
    }

    function postIndex(Request $request){

        $result = new \stdClass();
        $result->error = false;
        $result->message = '';

        $validation = Validator::make([], []); //fake validation

        if ($request->set_passcode){

            if ($request->my_passcode != null) {
                $company = Company::find($this->theCompany->id);
                $company->passcode = $request->my_passcode;
                $company->save();
                $result->message = Lang::get('messages.saved');
            } else {
                $result->error = true;
                $result->message = Lang::get('connection.please_put_passcode');
            }

        }

        if ($request->add_connection){

            $rules = [
                'url'=>'required|url|unique:connection',
                'passcode'=>'required'
            ];

            $validation = Validator::make($request->input(), $rules);

            if ($validation->fails()){
                $result->error = true;
            } else {

                $connection = new Connection();
                $connection->url = $request->url;
                $connection->passcode = $request->passcode;
                $connection->save();
                $result->message = Lang::get('connection.added');

            }

        }

        return ($result->error) ? back()->withInput()
            ->with('danger', $result->message)->withErrors($validation->errors()) : back()->with('success', $result->message);

    }

    function getDelete($id){

        Connection::where('id', $id)->delete();

        return back()->with('success', Lang::get('messages.success_delete'));

    }

}