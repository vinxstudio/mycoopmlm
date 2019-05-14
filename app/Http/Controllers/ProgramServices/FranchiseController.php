<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\FranchiseRequest;

use App\Models\Franchise;
use App\Models\ProgramService;
use App\Models\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FranchiseController extends MemberAbstract {

	protected $model;

	public function __construct(Franchise $franchise)
	{
		parent::__construct();
		$this->model = $franchise;
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
	 * @param FranchiseRequest $request
	 * @return Response
	 */
	public function store(FranchiseRequest $request)
	{
        try {
        	$requester_id = Auth::user()->id;

    		$programServiceId = ProgramService::TYPE_FRANCHISE;

			$franchise = new Franchise(array_merge($request->all(), [
				'requester_id' => $requester_id
			]));
			$franchise->save();

			$transactions = new Transactions([
				'requester_id' 		 => $requester_id,
				'program_service_id' => $programServiceId,
				'status'			 => Transactions::STATUS_PAID,
				'account_id'		 => Auth::user()->account->id
			]);
			$transactions->save();

			//Create polymorphic values for transactions details column
			$franchise->transactions()->save($transactions);

			return redirect('member/transactions')->with('message', 'Successfully applied for Franchise.');
        } catch (Exception $e) {
        	return redirect()->back()->with('danger', 'Unable to apply for Franchise.');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Franchise  $franchise
	 * @return Response
	 */
	public function show(Franchise $franchise)
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
