<?php namespace App\Http\Modules\Admin\Dashboard\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Accounts;
use App\Models\ActivationCodes;
use App\Models\CompanyEarnings;
use App\Models\Connection;
use App\Models\User;

class DashboardAdminController extends AdminAbstract {

    protected $viewpath = 'Admin.Dashboard.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){

//         $defaultAccount = Accounts::find(1);
        $code = DB::table('activation_codes')->count();
        $members = DB::table('users')->where('role', 'member')->count();
        $accounts = DB::table('accounts')->count();
        $company_earnings = DB::table('company_earnings')->sum('amount');
        $connections = Connection::all();
//         $carries = DB::table('accounts')->get();

        return view($this->viewpath.'welcome')
            ->with(
                [
                    // 'codes'=>ActivationCodes::all()->count(),
                    // 'members'=>User::where('role', 'member')->get(),
                    // 'accounts'=>Accounts::all()->count(),
                    // 'companyIncome'=>CompanyEarnings::sum('amount'),
                    // 'connections'=>Connection::all(),
                    // 'carries'=>$defaultAccount->carries

                    'codes' => $code,
                    'members' => $members,
                    'accounts' => $accounts,
                    'companyIncome' => $company_earnings,
                    'connections' =>$connections
                ]
            );
    }

}
