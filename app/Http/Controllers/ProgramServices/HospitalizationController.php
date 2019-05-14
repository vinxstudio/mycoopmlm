<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\EWallet;
use App\Models\Hospitalization;
use App\Models\ProgramService;
use App\Models\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HospitalizationController extends MemberAbstract {

	protected $model;

	public function __construct(Hospitalization $hospitalization)
	{
		parent::__construct();
		$this->model = $hospitalization;
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
		$eWallet = new EWallet();
		$cost = Hospitalization::COSTS[$request->type];

		//Check if eWallet has sufficient funds.
		if (!$eWallet->hasSufficientFunds($cost)) {
			return redirect()->back()->with('danger', 'Insufficient funds.');
		}

        try {
        	$requester_id = Auth::user()->id;

			$hospitalization = new Hospitalization(array_merge($request->all(), [
				'requester_id'                    => $requester_id,
		        'family_immediate_last_name_1'    => $request->family_immediate['last_name'][0],
		        'family_immediate_first_name_1'   => $request->family_immediate['first_name'][0],
		        'family_immediate_middle_name_1'  => $request->family_immediate['middle_name'][0],
		        'family_immediate_relationship_1' => $request->family_immediate['relationship'][0],
		        'family_immediate_birthdate_1'    => $request->family_immediate['birthdate'][0],
		        'family_immediate_gender_1'       => $request->family_immediate['gender'][0],
		        'family_immediate_civil_status_1' => $request->family_immediate['civil_status'][0],
		        'family_immediate_last_name_2'    => $request->family_immediate['last_name'][1],
		        'family_immediate_first_name_2'   => $request->family_immediate['first_name'][1],
		        'family_immediate_middle_name_2'  => $request->family_immediate['middle_name'][1],
		        'family_immediate_relationship_2' => $request->family_immediate['relationship'][1],
		        'family_immediate_birthdate_2'    => $request->family_immediate['birthdate'][1],
		        'family_immediate_gender_2'       => $request->family_immediate['gender'][1],
		        'family_immediate_civil_status_2' => $request->family_immediate['civil_status'][1],
		        'family_immediate_last_name_3'    => $request->family_immediate['last_name'][2],
		        'family_immediate_first_name_3'   => $request->family_immediate['first_name'][2],
		        'family_immediate_middle_name_3'  => $request->family_immediate['middle_name'][2],
		        'family_immediate_relationship_3' => $request->family_immediate['relationship'][2],
		        'family_immediate_birthdate_3'    => $request->family_immediate['birthdate'][2],
		        'family_immediate_gender_3'       => $request->family_immediate['gender'][2],
		        "family_immediate_civil_status_3" => $request->family_immediate['civil_status'][2]
			]));
			$hospitalization->save();

			$transactions = new Transactions([
				'requester_id' 		 => $requester_id,
				'program_service_id' => ProgramService::TYPE_HOSPITALIZATION,
				'cost'			     => $cost,
				'status'			 => Transactions::STATUS_PAID,
				'account_id'		 => Auth::user()->account->id
			]);
			$transactions->save();

			//Create polymorphic values for transactions details column
			$hospitalization->transactions()->save($transactions);

			//Debit purchased amount to eWallet balance
			$eWallet->debitEwallet($cost);
			
			return redirect('member/transactions')->with('message', 'Successfully applied for Hospitalization.');
        } catch (Exception $e) {
        	return redirect()->back()->with('danger', 'Unable to apply for Hospitalization.');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Hospitalization $hospitalization
	 * @return Response
	 */
	public function show(Hospitalization $hospitalization)
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
