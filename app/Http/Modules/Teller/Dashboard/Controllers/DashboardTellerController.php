<?php namespace App\Http\Modules\Teller\Dashboard\Controllers;

use App\Http\AbstractHandlers\TellerAbstract;
use App\Http\Requests;
use App\Models\Accounts;
use App\Models\ActivationCodes;
use App\Models\CompanyEarnings;
use App\Models\Connection;
use App\Models\User;

class DashboardTellerController extends TellerAbstract {

    protected $viewpath = 'Teller.Dashboard.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){

        $defaultAccount = Accounts::find(1);

        return view($this->viewpath.'welcome')
            ->with(
                [
                    'codes'=>ActivationCodes::all(),
                    'members'=>User::where('role', 'member')->get(),
                    'accounts'=>Accounts::all(),
                    'companyIncome'=>CompanyEarnings::sum('amount'),
                    'connections'=>Connection::all(),
                    'carries'=>$defaultAccount->carries
                ]
            );
    }

}
