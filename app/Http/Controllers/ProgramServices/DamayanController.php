<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\DamayanRequest;

use App\Models\EWallet;
use App\Models\Damayan;
use App\Models\ProgramService;
use App\Models\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DamayanController extends MemberAbstract {

	protected $model;

	public function __construct(Damayan $damayan)
	{
		parent::__construct();
		$this->model = $damayan;
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
	public function store(DamayanRequest $request)
	{
		$eWallet = new eWallet();
		$cost    = DAMAYAN::RANGES[$request->age_range]['amount'];
		//Check if eWallet has sufficient funds.
		if (!$eWallet->hasSufficientFunds($cost)) {
			return redirect()->back()->with('danger', 'Insufficient funds.');
		}

        try {
        	$requester_id = Auth::user()->id;
        	
			$damayan      = new Damayan(array_merge($request->all(), [
				'requester_id' => $requester_id,
				'cost'         => $cost,
			]));
			$damayan->save();

			$transactions = new Transactions([
				'requester_id' 		 => $requester_id,
				'program_service_id' => ProgramService::TYPE_DAMAYAN,
				'cost'			     => $cost,
				'status'			 => Transactions::STATUS_PAID,
				'account_id'		 => Auth::user()->account->id
			]);
			$transactions->save();

			//Create polymorphic values for transactions details column
			$damayan->transactions()->save($transactions);

			//Debit purchased amount to eWallet balance
			$eWallet->debitEwallet($cost);
			
			return redirect('member/transactions')->with('message', 'Successfully purchased Damayan.');
        } catch (Exception $e) {
        	return redirect()->back()->with('danger', 'Unable to purchased Damayan.');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Damayan  $damayan
	 * @return Response
	 */
	public function show(Damayan $damayan)
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
