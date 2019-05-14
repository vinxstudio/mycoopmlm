<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;

use App\Models\Transactions;
use App\Models\UserDetails;
use App\Models\ProgramService;

use Illuminate\Http\Request;

class TransactionsController extends MemberAbstract {

	protected $model;

	public function __construct(Transactions $transactions)
	{
		parent::__construct();
		$this->model = $transactions;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::user()->role === 'admin') {
			return view('transactions.index', [ 'transactions' => $this->model->getAllPaginatedList()]);	
		}

		return view('transactions.index', [ 'transactions' => $this->model->getUserPaginatedList()]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Transactions  $transactions
	 * @return Response
	 */
	public function show(Transactions $transactions)
	{
		switch ($transactions->details_type) {
			case 'App\Models\Savings':
				return view('savings.detail', array_merge(
					[ 	
						'data'              => $transactions->details,
						'status_string'     => $transactions->status_string,
						'image_banner_path' => ProgramService::where(['id' => ProgramService::TYPE_SAVINGS])->first()->image_banner_path
					]
				));
				break;
			case 'App\Models\Damayan':
				return view('damayan.detail', $transactions->details);
				break;
			case 'App\Models\Financing':
				return view('Financing.detail', array_merge(
					[ 	
						'data'          => $transactions->details,
						'status_string' => $transactions->status_string
					]
				));
			case 'App\Models\Franchise':
				return view('franchise.detail', array_merge(
					[	
						'data'              => $transactions->details,
					  	'image_banner_path' => ProgramService::where(['id' => ProgramService::TYPE_FRANCHISE])->first()->image_banner_path,
					  	'status_string' => $transactions->status_string
					]
				));
			case 'App\Models\Hospitalization':
				return view('hospitalization.detail', array_merge(
					[	
						'data'              => $transactions->details,
					  	'image_banner_path' => ProgramService::where(['id' => ProgramService::TYPE_HOSPITALIZATION])->first()->image_banner_path,
					  	'status_string'     => $transactions->status_string
					]
				));
				break;
			case 'App\Models\ETours':
				return view('etours.detail', array_merge(
					[ 	
						'data'              => $transactions->details,
						'status_string'     => $transactions->status_string,
						'image_banner_path' => ProgramService::where(['id' => ProgramService::TYPE_ETOURS])->first()->image_banner_path
					]
				));
			case 'App\Models\EHotel':
				return view('ehotel.detail', array_merge(
					[ 	
						'data'              => $transactions->details,
						'status_string'     => $transactions->status_string,
						'image_banner_path' => ProgramService::where(['id' => ProgramService::TYPE_EHOTEL])->first()->image_banner_path
					]
				));
				break;
		}
		
		return redirect()->back()->with('danger', 'Purchase form not found.');
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
