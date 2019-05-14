<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\SavingsRequest;

use App\Models\EWallet;
use App\Models\Savings;
use App\Models\ProgramService;
use App\Models\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SavingsController extends MemberAbstract {

	protected $model;

	public function __construct(Savings $savings)
	{
		parent::__construct();
		$this->model = $savings;
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
	 * @param SavingsRequest $request
	 * @return Response
	 */
	public function store(SavingsRequest $request)
	{
		$eWallet = new EWallet();

		//Check if eWallet has sufficient funds.
		if (!$eWallet->hasSufficientFunds($request->amounts)) {
			return redirect()->back()->with('danger', 'Insufficient funds.');
		}

        try {
        	$requester_id = Auth::user()->id;
        	
        	foreach($request->types as $key => $type) {
        		$programServiceId = ProgramService::TYPE_SAVINGS;

				$savings = new Savings(array_merge($request->all(), [
					'requester_id' => $requester_id,
					'type'         => $type,
					'amount'	   => $request->amounts[$key],
				]));
				$savings->save();

				$transactions = new Transactions([
					'requester_id' 		 => $requester_id,
					'program_service_id' => $programServiceId,
					'amount'			 => $request->amounts[$key],
					'status'			 => Transactions::STATUS_PAID,
					'account_id'		 => Auth::user()->account->id
				]);
				$transactions->save();

				//Create polymorphic values for transactions details column
				$savings->transactions()->save($transactions);

				//Debit purchased amount to eWallet balance
				$eWallet->debitEwallet($request->amounts[$key]);
			}

			return redirect('member/transactions')->with('message', 'Successfully purchased Savings.');
        } catch (Exception $e) {
        	return redirect()->back()->with('danger', 'Unable to purchased Savings.');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Savings  $savings
	 * @return Response
	 */
	public function show(Savings $savings)
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
