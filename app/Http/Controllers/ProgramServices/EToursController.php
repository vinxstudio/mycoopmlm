<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\EToursRequest;

use App\Models\EWallet;
use App\Models\ETours;
use App\Models\ProgramService;
use App\Models\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EToursController extends MemberAbstract {

	protected $model;

	public function __construct(ETours $etours)
	{
		parent::__construct();
		$this->model = $etours;
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
	 * @param EToursRequest $request
	 * @return Response
	 */
	public function store(EToursRequest $request)
	{
        try {
        	$requester_id = Auth::user()->id;

    		$programServiceId = ProgramService::TYPE_ETOURS;

			$etours = new ETours(array_merge($request->all(), [
				'requester_id' => $requester_id
			]));
			$etours->save();

			$transactions = new Transactions([
				'requester_id' 		 => $requester_id,
				'program_service_id' => $programServiceId,
				'status'			 => Transactions::STATUS_PENDING,
				'account_id'		 => Auth::user()->account->id
			]);
			$transactions->save();

			//Create polymorphic values for transactions details column
			$etours->transactions()->save($transactions);

			return redirect('member/transactions')->with('message', 'Successfully applied for ETours.');
        } catch (Exception $e) {
        	return redirect()->back()->with('danger', 'Unable to apply for ETours.');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  ETours  $etours
	 * @return Response
	 */
	public function show(ETours $etours)
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
