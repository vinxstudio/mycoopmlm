<?php namespace App\Http\Modules\FrontEnd\Validation;

use App\Http\AbstractHandlers\MainValidationHandler;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FrontEndValidationHandler extends MainValidationHandler{

    function __construct(){
        parent::__construct();
    }

    function validate(){
        $inputs = $this->getInputs();

        $remember = (isset($inputs['remember_me']) and $inputs['remember_me'] == 'on') ? true : false;

        $credentials = [
            'username' => $inputs['email'],
            'password' => $inputs['password']
        ];

        if (!Auth::attempt($credentials, $remember)) {
			
			$counter = User::where("username", "LIKE", "\\" . $inputs['email'] . "-%")->count();
			
			if($counter > 0) {
				$getUsername = User::where("username", "LIKE", "\\" . $inputs['email'] . "-%")->first();
				$credentials = [
					'username' => $getUsername->username,
					'password' => $inputs['password']
				];
				if (!Auth::attempt($credentials, $remember)) {
					$this->result->error = true;
					$this->result->message_type = 'danger';
					$this->result->message = 'Invalid username or password.';
				}
			} else {
				$this->result->error = true;
				$this->result->message_type = 'danger';
				$this->result->message = 'Invalid username or password.';
			}
        } else {
            session('role', Auth::user()->role);
        }

        return $this->result;
    }

}