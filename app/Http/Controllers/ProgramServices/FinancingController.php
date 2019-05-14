<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Financing;
use App\Models\ProgramService;
use App\Models\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FinancingController extends MemberAbstract {

	protected $model;

	public function __construct(Financing $financing)
	{
		parent::__construct();
		$this->model = $financing;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
        try {
        	$requester_id     = Auth::user()->id;
    		$programServiceId = ProgramService::TYPE_FINANCING;

			$financing = new Financing(array_merge($request->all(), [
				'application_date' => date('Y-m-d h:i:s'),
				'requester_id'     => $requester_id
			]));
			$financing->save();

			$transactions = new Transactions([
				'requester_id' 		 => $requester_id,
				'program_service_id' => $programServiceId,
				'amount'			 => $request->application_amount,
				'status'			 => Transactions::STATUS_PENDING,
				'account_id'		 => Auth::user()->account->id
			]);
			$transactions->save();

			//Create polymorphic values for transactions details column
			$financing->transactions()->save($transactions);
			
			return redirect('member/transactions')->with('message', 'Successfully applied for loan.');
        } catch (Exception $e) {
        	return redirect()->back()->with('danger', 'Unable to apply for loan.');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Savings  $savings
	 * @return Response
	 */
	public function show(Financing $financing)
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}
}
