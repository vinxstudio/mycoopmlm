<?php

namespace App\Http\Controllers\ProgramServices;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Http\Requests;
use Auth;

use App\Models\Damayan;
use App\Models\Financing;
use App\Models\Savings;
use App\Models\ETours;
use App\Models\Products;
use App\Models\ProgramService;
use App\Models\UserDetails;

use Illuminate\Http\Request;

class ProgramServicesController extends MemberAbstract {

	protected $model;

	public function __construct(ProgramService $programService, Products $products)
    {
    	parent::__construct();
        $this->model = $programService;
        $this->productsModel = $products;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('program_services.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  ProgramService $progamService
	 * @return View
	 */
	public function show(ProgramService $programService, Request $request)
	{
		//Check if with custom form.
		if (!$programService->form_path) return view('program_services.purchase');

		//Get additional form data, if any.
		$data = [];
		$data['user'] = UserDetails::where(['id' => Auth::user()->user_details_id])->first();
		
		switch ($programService->name) {
			case 'Savings':
				$data['types'] = Savings::TYPES;
				break;
			case 'Damayan':
				$data['types']  = Damayan::TYPES;
				$data['ranges'] = Damayan::RANGES;
				break;
			case 'eCommerce':
				$sort     = $request->input('sort');
				$order    = $request->input('order');
				$category = $request->input('category');

				$data['categories'] = Products::CATEGORIES;
				$data['products']   = $this->productsModel->getFrontendProducts($order, $sort, $category);
				break;
			case 'Financing':
				$data['types']      = Financing::TYPES;
				$data['classes']    = Financing::CLASSES;
				$data['repayments'] = Financing::REPAYMENTS;
				break;
			case 'eTours':
				$data['types'] = ETours::TYPES;
				break;
		}
		
		return view($programService->form_path, array_merge(
			$data, 
			$programService->toArray()
		));
	}

	/**
	 * Gets all published services for frontend.
	 *
	 * @return Services[]
	 */
	private function getPublishedServices()
	{
		return $this->model
					->where([ 'publish_status' => 1, 'type' => ProgramService::TYPE_SERVICES ])
					->where('publish_date', '<=', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
					->orderBy('order', 'asc')
					->get([ 'slug', 'name', 'image_icon_path' ]);
	}

	/**
	 * Gets all published progams for frontend.
	 *
	 * @return Progams[]
	 */
	private function getPublishedProgams()
	{
		return $this->model
					->where([ 'publish_status' => 1, 'type' => ProgramService::TYPE_PROGRAMS ])
					->where('publish_date', '<=', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
					->orderBy('order', 'asc')
					->get([ 'slug', 'name', 'image_icon_path' ]);
	}
}
