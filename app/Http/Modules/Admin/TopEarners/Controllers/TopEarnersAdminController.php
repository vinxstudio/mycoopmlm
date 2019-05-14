<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 5/31/17
 * Time: 7:27 PM
 */

namespace App\Http\Modules\Admin\TopEarners\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Earnings;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\MemberGrossIncome;


class TopEarnersAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.TopEarners.views.';
    protected $getTop = 5;
    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        
        $member_gross_income = new MemberGrossIncome();
        
        $gross_income = $member_gross_income->getGrossIncome();
        
        return view($this->viewpath . 'index')
                    ->with([
                        'gross_income'=> $gross_income,
                    ]);
    }

    function exportGrossIncome($type){

        $member_gross_income = new MemberGrossIncome();
        
        $gross = $member_gross_income->getGrossIncome('download');
      
        return \Excel::create('Member_Gross_Income', function($excel) use($gross) {

            $excel->sheet('Member_Gross_Income', function($sheet) use(&$gross)
            {
                $sheet->loadView($this->viewpath . 'top_earners_excel' )
                    ->withGross($gross);
            });

        })->download($type);

    }

}