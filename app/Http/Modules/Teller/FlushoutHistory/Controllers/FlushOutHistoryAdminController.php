<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 8:05 PM
 */

namespace App\Http\Modules\Admin\FlushOutHistory\Controllers;

// use App\Helpers\Binary;
use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\User;
// use App\Models\Earnings;
use App\Models\Accounts;
use App\Models\UserDetails;
use App\Models\ActivationCodes;
use App\Models\Membership;
use App\Models\ConvertGC;
use App\Models\Flushout;
use Illuminate\Http\Request;
use App\Http\TraitLayer\UserTrait;
use Response;
use Validator;

class FlushOutHistoryAdminController extends AdminAbstract{

    use UserTrait;
    protected $viewpath = 'Admin.FlushOutHistory.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex($date_from = null, $date_to = null){

        $date_from = (!empty($date_from))? $date_from : '';
        $date_to = (!empty($date_to))? $date_to : '';

        $overall_total = Flushout::select('amount')->whereIn('source', ['pairing'])->sum('amount');

        $q = Flushout::select('amount')->whereIn('source', ['pairing']);
        if(!empty($date_from)) $q->where('flushout.created_at', '>=', $date_from);
        if(!empty($date_to)) $q->where('flushout.created_at', '<=', $date_to);
        $flushout_total = $q->sum('amount');

        $flushout_model = new Flushout;
        $flushout = $flushout_model->getFlushout();

        if(!empty($date_from)) $flushout->where('flushout.created_at', '>=', $date_from);
        if(!empty($date_to)) $flushout->where('flushout.created_at', '<=', $date_to);

        $flushout_list = $flushout->paginate(50);
        
        return view( $this->viewpath . 'index' )
                ->with([
                    'overall_total' => $overall_total,
                    'flushout_list' => $flushout_list,
                    'flushout_total' => (!empty($flushout_total)) ? $flushout_total : 0,
                    'date_from' => $date_from,
                    'date_to' => $date_to
                ]);
     }

     function postIndex(Request $request)
     {
        if(!empty($request->input('date_range')) ) {
            return redirect('/admin/flushout-history/index/'.$request->input('date_from').'/'.$request->input('date_to'));
        }
     }

    function exportFlushout($type, $date_from=null, $date_to=null ){
        $flushout_model = new Flushout;
        $flushout = $flushout_model->getFlushout();

        if(!empty($date_from)) $flushout->where('flushout.created_at', '>=', $date_from);
        if(!empty($date_to)) $flushout->where('flushout.created_at', '<=', $date_to);
        
        $flushout_list = $flushout->get();
     
        return \Excel::create('Flushout_Report', function($excel) use($flushout_list) {

            $excel->sheet('Flushout_Report', function($sheet) use(&$flushout_list)
            {
                $sheet->loadView($this->viewpath . 'flushout_history_excel' )
                    ->withFlushout_list($flushout_list);
            });

        })->download($type);
    }

}
