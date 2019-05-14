<?php 

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\EHotelRequest;

use App\Models\EWallet;
use App\Models\EHotel;
use App\Models\ProgramService;
use App\Models\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EHotelController extends MemberAbstract {

	protected $model;

	public function __construct(EHotel $eHotel)
	{
		parent::__construct();
		$this->model = $eHotel;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param EHotelRequest $request
	 * @return Response
	 */
	public function store(EHotelRequest $request)
	{
		$eWallet = new EWallet();

        try {
        	$requester_id = Auth::user()->id;

    		$programServiceId = ProgramService::TYPE_EHOTEL;
    		
			$eHotel = new EHotel(array_merge($request->all(), [
				'requester_id' => $requester_id,
			]));
			$eHotel->save();

			$transactions = new Transactions([
				'requester_id' 		 => $requester_id,
				'program_service_id' => $programServiceId,
				'status'			 => Transactions::STATUS_PAID,
				'account_id'		 => Auth::user()->account->id
			]);
			$transactions->save();

			//Create polymorphic values for transactions details column
			$eHotel->transactions()->save($transactions);

			return redirect('member/transactions')->with('message', 'Successfully purchased EHotel.');
        } catch (Exception $e) {
        	return redirect()->back()->with('danger', 'Unable to purchased EHotel.');
        }
	}
}
