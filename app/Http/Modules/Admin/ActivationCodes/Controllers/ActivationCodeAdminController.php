<?php namespace App\Http\Modules\Admin\ActivationCodes\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\Modules\Admin\ActivationCodes\Validation\ActivationCodeValidationHandler;
use App\Http\Requests;
use App\Models\ActivationCodeBatches;
use App\Models\ActivationCodes;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;
use Carbon\Carbon;

class ActivationCodeAdminController extends AdminAbstract
{

    protected $viewpath = 'Admin.ActivationCodes.views.';
    function __construct()
    {
        parent::__construct();
    }

    function getIndex($filter = null, $date_from = null, $date_to = null)
    {
        //$membership = Membership::find(0);
        $code_dates = ActivationCodes::select('created_at')->orderBy('created_at', 'DESC')->get();

        $month_range = array();
        foreach ($code_dates as $dates) {
            // $month_year =  Carbon::parse($dates['created_at'])->format('F, Y');
            // $month_num = Carbon::parse($dates['created_at'])->month;
            $startDate = date('Y-m-01', strtotime($dates->created_at));
            $endDate = date('Y-m-t', strtotime($dates->created_at));

            $start_date_index = date("Y-m-d", strtotime($startDate)) . ' 00:00:01';
            $end_date_index = date("Y-m-d", strtotime($endDate)) . ' 23:59:59';

            $date_range_index = $start_date_index . '_' . $end_date_index;

            if (!in_array($date_range_index, $month_range)) {
                $month_range[$date_range_index] = Carbon::parse($startDate)->format('F d, Y') . ' - ' . Carbon::parse($endDate)->format('F d, Y');
            }
        }

        if (!$filter || $filter == 'date-range' || $filter == 'monthly') {
            if (empty($date_from) && empty($date_to)) {
                $startDate = date('Y-m-01');
                $endDate = date('Y-m-t');

                $start_date_index = date("Y-m-d", strtotime($startDate)) . ' 00:00:01';
                $end_date_index = date("Y-m-d", strtotime($endDate)) . ' 23:59:59';

                $date_from = $start_date_index;
                $date_to = $end_date_index;
            }
        }

        $activation_codes = new ActivationCodes;
        $q = $activation_codes->getActivationCodes();

        $q->where('activation_codes.id', '!=', 0);

        if (!empty($date_from)) $q->where('activation_codes.created_at', '>=', $date_from);
        if (!empty($date_to)) $q->where('activation_codes.created_at', '<=', $date_to);

        if ($filter && $filter != 'monthly' && $filter != 'date-range') {
            $q->where('activation_codes.code', 'LIKE', '%' . $filter . '%');
        }

        $codes = $q->paginate(10);

        return view($this->viewpath . 'code-list')
            ->with(
                [
                    // 'batches'=>ActivationCodeBatches::paginate(50),
                    'codes' => $codes,
                    'membership' => Membership::where('id', '<=', 6)->get(),
                    'month_range' => $month_range,
                    'date_from' => $date_from,
                    'date_to' => $date_to,
                    'filter' => $filter
                ]
            );
    }

    function postIndex(Request $request)
    {
        if (!empty($request->input('month'))) {
            $filter = 'monthly';
            $month_range = explode('_', $request->month);
            return redirect('/admin/activation-codes/index/' . $filter . '/' . $month_range[0] . '/' . $month_range[1]);
        } else if (!empty($request->input('date_range'))) {
            $filter = 'date-range';
            return redirect('/admin/activation-codes/index/' . $filter . '/' . $request->input('date_from') . '/' . $request->input('date_to'));
        } else if ($request->has('activation_name')) {
            $filter = $request->activation_name;
            return redirect('/admin/activation-codes/index/' . $filter);
        } else {
            $codeValidator = new ActivationCodeValidationHandler();
            $codeValidator->setTellerId($this->theUser->id);
            $codeValidator->setInputs($request->input());
            $result = $codeValidator->validate();

            Session::flash($result->message_type, $result->message);

            return ($result->error) ? redirect('admin/activation-codes')->withErrors($result->validation->errors())->withInput() : redirect('admin/activation-codes/view-batch/' . $result->batch_id);
        }
    }

    function getViewBatch($id = null)
    {
        $activation_codes = new ActivationCodes;
        $q = $activation_codes->getActivationCodes();
        return view($this->viewpath . 'view-codes')->with(
            [
                'codes' => $q->where('batch_id', $id)->paginate(10)
            ]
        );
    }

    function postDeleteCode(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'activation_id' => 'required',
            'delete_reason' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => "Reason field is required!"]);
        }

        $code = ActivationCodes::where('id', $id)
            ->update([
                'status' => 'cancelled',
                'reason' => $request->input('delete_reason')
            ]);
        if ($code) {
            return response()->json(['message' => "Success!"]);
        }
    }

    function getReason($id)
    {
        $code = ActivationCodes::select('reason')->where('id', $id)->first();

        if ($code) {
            return response()->json($code);
        }
    }

    function exportFile($type, $date_from = null, $date_to = null)
    {

        $date_from = (!empty($date_from)) ? $date_from : '';
        $date_to = (!empty($date_to)) ? $date_to : '';

        $activation_codes = new ActivationCodes;
        $q = $activation_codes->getActivationCodes();

        $q->where('activation_codes.id', '!=', 0);

        if (!empty($date_from)) $q->where('activation_codes.created_at', '>=', $date_from);
        if (!empty($date_to)) $q->where('activation_codes.created_at', '<=', $date_to);

        $codes = $q->get();

        return \Excel::create('Activation_Code', function ($excel) use ($codes) {

            $excel->sheet('Activation_Code', function ($sheet) use (&$codes) {
                $sheet->loadView($this->viewpath . 'code_list_excel')
                    ->withCodes($codes);
            });
        })->download($type);
    }
}
