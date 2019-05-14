<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 5/14/17
 * Time: 1:28 PM
 */

namespace App\Http\Modules\Admin\Transactions\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Earnings;
use Illuminate\Http\Request;

class TransactionsAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.Transactions.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex( $month = null, $year = null ){

        $month = ($month == null) ? date('m') : $month;
        $year = ($year == null) ? date('Y') : $year;

        $earnings = Earnings::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->orderBy('created_at', 'DESC')->get();

        $theDates = $this->getEarningsDates();

        return view( $this->viewpath . 'index' )
            ->with([
                'earnings'=>$earnings,
                'datesDropdown'=>$theDates
            ]);
    }

    function postIndex(Request $request){
        $timestamp = strtotime($request->date . '-01');

        return redirect( sprintf('admin/transactions/index/%s/%s', date('m', $timestamp), date('Y', $timestamp)) );
    }

}