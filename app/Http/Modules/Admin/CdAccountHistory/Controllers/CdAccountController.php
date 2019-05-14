<?php namespace App\Http\Modules\Admin\CdAccountHistory\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\Modules\Admin\ActivationCodes\Validation\ActivationCodeValidationHandler;
use App\Http\Requests;
use App\Models\ActivationCodeBatches;
use App\Models\ActivationCodes;
use App\Models\Membership;
use App\Models\User;
use App\Models\Earnings;
use App\Models\UserDetails;
use App\Models\Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;
use Carbon\Carbon;

class CdAccountController extends AdminAbstract {

    protected $viewpath = 'Admin.CdAccountHistory.views.';
    function __construct(){
        parent::__construct();
    }

    function getIndex($keyword = null){

        $users = new UserDetails;

        $details = $users->getCdAccounts($keyword);
      
        return view($this->viewpath . 'index')
            ->with([
                'members'=> $details,
                'search_keyword' => $keyword
            ]);
    }

    function postIndex(Request $request){
        if(!empty($request->input('keyword')) ) {
            return redirect('/admin/cd-accounts/index/'.$request->input('keyword'));
        }else{
            return redirect('/admin/cd-accounts/');
        }

    }

    function exportCdAccounts($type, $search_keyword = null){

        $users = new UserDetails;

        $members = $users->getCdAccounts($search_keyword, 'download');
      
        return \Excel::create('CD_Account_Report', function($excel) use($members) {

            $excel->sheet('CD_Account_Report', function($sheet) use(&$members)
            {
                $sheet->loadView($this->viewpath . 'cd_list_excel' )
                    ->withMembers($members);
            });

        })->download($type);

    }
}
