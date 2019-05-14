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

class TellerAbstract extends MainAbstract{

    protected $theUser;
    protected $theCompany;
    protected $template = 'layouts.master';
    function __construct(){
        $user = Auth::user();

        $this->theUser = $user;
        $this->theCompany = Company::find(1);

        view()->share(
            [
                'theUser' => $user,
                'company'=>$this->theCompany,
                'menus'=>$this->adminMenus,
                'template'=>$this->template,
                'currencies'=>$this->currencies
            ]
        );
    }

}