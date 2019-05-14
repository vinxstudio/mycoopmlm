<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 11:26 AM
 */

namespace App\Http\Modules\Admin\MaintenanceHistory\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Accounts;
use App\Models\User;
use App\Models\Withdrawals;
use App\Models\ForMaintenance;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class MaintenanceHistoryAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.MaintenanceHistory.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(Request $request, $date_from = null, $date_to = null){

        $maintenance_teller = new ForMaintenance();
        $teller = $maintenance_teller->getMaintenance(); // get data

        $maintenance_deposit = new Withdrawals();
        $deposit = $maintenance_deposit->getMaintenance(); // get data

        $dates_teller = ForMaintenance::select('created_at')->get();
        $dates_deposit = Withdrawals::select('created_at')->where('maintenance', '!=', 0)->get();
        
        // $months = array();
        $months = array_merge($dates_teller->toArray(), $dates_deposit->toArray());
        rsort($months);
        $month_range = array();
       foreach ($months as $dates) {
            // $month_year =  Carbon::parse($dates['created_at'])->format('F, Y');
            // $month_num = Carbon::parse($dates['created_at'])->month;
            $startDate = date('Y-m-01', strtotime($dates['created_at']));
            $endDate = date('Y-m-t', strtotime($dates['created_at']));
            
            $start_date_index = date("Y-m-d", strtotime($startDate)).' 00:00:01';
            $end_date_index = date("Y-m-d", strtotime($endDate)).' 23:59:59';

            $date_range_index = $start_date_index.'_'.$end_date_index;

            if(!in_array($date_range_index, $month_range))
            {
                $month_range[$date_range_index] = Carbon::parse($startDate)->format('F d, Y').' - '.Carbon::parse($endDate)->format('F d, Y');
            }
        }

        if(empty($date_from) && empty($date_to)){
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');

            $start_date_index = date("Y-m-d", strtotime($startDate)).' 00:00:01';
            $end_date_index = date("Y-m-d", strtotime($endDate)).' 23:59:59';

            $date_from = $start_date_index;
            $date_to = $end_date_index;
        }
      
       if(!empty($date_from)){
            $teller->where('for_maintenance.created_at', '>=', $date_from);
            $deposit->where('withdrawals.created_at', '>=', $date_from);
        }
        if(!empty($date_to)){
            $teller->where('for_maintenance.created_at', '<=', $date_to);
            $deposit->where('withdrawals.created_at', '<=', $date_to);
        }
      
        $t_details = $teller->get();
        $d_details = $deposit->get();

        $maintenance_details = [];
        $total_maintenance = 0;
        foreach ($t_details as $t) {
            $total_maintenance += $t->cbu;
            $my_c = ($t->my_c == 1) ? 600 : $t->my_c; 
            $maintenance_details[] = [
                'first_name' => $t->first_name,
                'last_name' => $t->last_name,
                'username' => $t->username,
                'account_id' => $t->account_id,
                'CBU' => $t->cbu,
                'my_c' => $my_c,
                'receipt' => $t->receipt,
                'created_at' => $t->created_at->format("Y-m-d H:i:s"),
                'from' => 'Teller'
            ];
        }

        foreach ($d_details as $d) {
             $total_maintenance += $d->maintenance;
            $maintenance_details[] = [
                'first_name' => $d->first_name,
                'last_name' => $d->last_name,
                'username' => $d->username,
                'account_id' => $d->account_id,
                'CBU' => $d->maintenance,
                'my_c' => 0,
                'receipt' => '',
                'created_at' => $d->created_at->format("Y-m-d H:i:s"),
                'from'  => 'Deposit Account'
            ];
        }

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
 
        // Create a new Laravel collection from the array data
        $itemCollection = collect($maintenance_details)->sortBy('created_at');
 
        // Define how many items we want to be visible in each page
        $perPage = 50;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($maintenance_details), $perPage);
 
        // set url path for generted links
        $paginatedItems->setPath($request->url());
 
        return view( $this->viewpath . 'index')
                ->with([
                    'maintenance' => $paginatedItems,
                    'month_range' => $month_range,
                    'date_from' =>$date_from,
                    'date_to'   =>$date_to,
                    'total_maintenance' => $total_maintenance,
                    // 'selected' => $selected
                ]);
    }
    function postIndex(Request $request)
    {   
        if(!empty($request->input('date_range')))
        {
            $month_range = explode('_',$request->month);
            return redirect('admin/maintenance-history/index/'.$request->input('date_from').'/'.$request->input('date_to'));
        }
    }
    function exportMaintenanceHistory($type, $date_from, $date_to){
        $maintenance_teller = new ForMaintenance();
        $teller = $maintenance_teller->getMaintenance(); // get data

        $maintenance_deposit = new Withdrawals();
        $deposit = $maintenance_deposit->getMaintenance(); // get data

       if(empty($date_from) && empty($date_to)){
           $startDate = date("M d, Y", strtotime('first day of this month'));
           $endDate = date("M d, Y", strtotime('last day of this month'));

           $start_date_index = date("Y-m-d", strtotime($startDate)).' 00:00:01';
           $end_date_index = date("Y-m-d", strtotime($endDate)).' 23:59:59';

           $date_from = $start_date_index;
           $date_to = $end_date_index;
       }

      if(!empty($date_from)){
           $teller->where('for_maintenance.created_at', '>=', $date_from);
           $deposit->where('withdrawals.created_at', '>=', $date_from);
       }
       if(!empty($date_to)){
           $teller->where('for_maintenance.created_at', '<=', $date_to);
           $deposit->where('withdrawals.created_at', '<=', $date_to);
       }

       $t_details = $teller->get();
       $d_details = $deposit->get();

       $maintenance_details = [];
       $total_maintenance = 0;
       foreach ($t_details as $t) {
            $total_maintenance += $t->cbu;
            $my_c = ($t->my_c == 1) ? 600 : $t->my_c; 
            $maintenance_details[] = [
                'first_name' => $t->first_name,
                'last_name' => $t->last_name,
                'username' => $t->username,
                'account_id' => $t->account_id,
                'CBU' => $t->cbu,
                'my_c' => $my_c,
                'receipt' => $t->receipt,
                'created_at' => $t->created_at->format("Y-m-d H:i:s"),
                'from' => 'Teller'
            ];
       }

       foreach ($d_details as $d) {
            $total_maintenance += $d->maintenance;
            $maintenance_details[] = [
                'first_name' => $d->first_name,
                'last_name' => $d->last_name,
                'username' => $d->username,
                'account_id' => $d->account_id,
                'CBU' => $d->maintenance,
                'my_c' => 0,
                'receipt' => '',
                'created_at' => $d->created_at->format("Y-m-d H:i:s"),
                'from'  => 'Deposit Account'
            ];
       }

       $itemCollection = collect($maintenance_details)->sortBy('created_at');
       $maintenanceexcel = array(
            'maintenance_details' => $itemCollection,
            'date_from'=>$date_from,
            'date_to'=>$date_to
        );

      return \Excel::create('Maintenance_Report', function($excel) use($maintenanceexcel) {

            $excel->sheet('Maintenance_Report', function($sheet) use(&$maintenanceexcel)
            {
                $sheet->loadView($this->viewpath . 'maintenance_excel' )
                    ->withMaintenanceexcel($maintenanceexcel);
            });

        })->download($type);
    }
      
}
