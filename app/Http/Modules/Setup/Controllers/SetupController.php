<?php namespace App\Http\Modules\Setup\Controllers;

use App\Http\Modules\Setup\Validation\SetupValidationHandler;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SetupController extends Controller {

    protected $viewpath = 'Setup.views.';

    function getGeneral(){

        view()->share(
            [
                'pagename'=>(!session('authenticated')) ? 'Verify Identity' : null
            ]
        );

        return (!session('authenticated') == true) ? view($this->viewpath.'authenticate') : view($this->viewpath.'setup')
            ->with(
                [
                    'membership'=>Membership::find(1)
                ]
            );
    }

    function postGeneral(Request $request){
        $validate = new SetupValidationHandler();
            $validate
                ->setInputs($request->input());

        $result = $validate->validate();

        Session::flash($result->message_type, $result->message);

        if (isset($result->proceedToLogin) and $result->proceedToLogin == true){
            Session::forget('authenticated');
            Session::flash('success', 'Great! You have successfully configured your business settings. You can now log-in to the system.');
            return redirect('auth/login');
        }

        return ($result->error) ? redirect('setup/general')->withInput()->withErrors((isset($result->validation)) ? $result->validation->errors() : []) : redirect('setup/general');
    }

}
