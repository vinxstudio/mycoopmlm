<?php

/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/23/16
 * Time: 8:21 AM
 */

namespace App\Http\AbstractHandlers;

use App\Models\Company;

use Illuminate\Support\Facades\Auth;

class AdminAbstract extends MainAbstract
{

    protected $theUser;
    # declare protected user variable
    # for accessing the user data from child class
    # user_true because $user variable is use -- fack
    protected $user_true;
    protected $theCompany;
    protected $template = 'layouts.master';
    function __construct()
    {
        $user = Auth::user();
        $this->user_true = $user;

        $this->theUser = $user->details;
        $this->theCompany = Company::find(1);

        view()->share(
            [
                'theUser' => $user,
                'company' => $this->theCompany,
                'menus' => $this->adminMenus,
                'template' => $this->template,
                'currencies' => $this->currencies
            ]
        );
    }

}