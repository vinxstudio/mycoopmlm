<?php namespace App\Http\Modules\Admin\Settings\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\Modules\Admin\Settings\Validation\CodeValidationHandler;
use App\Http\Requests;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingsAdminController extends AdminAbstract {

    protected $viewpath = 'Admin.Settings.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        return view($this->viewpath.'index')
            ->with(
                [
                    'company'=>Company::find(1)
                ]
            );
    }

    function postIndex(Request $request){
        $codeSet = new CodeValidationHandler();
        $codeSet->setRules([
            'activationPrefix'=>'required|min:3',
            'productPrefix'=>'required|min:3'
        ])->setInputs($request->input());

        $result = $codeSet->validate();

        Session::flash($result->message_type, $result->message);

        return ($result->error) ? redirect('admin/settings')->withError($result->validation->errors())->withInput() : redirect('admin/settings');
    }

}
