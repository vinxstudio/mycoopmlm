<?php 

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EToursRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'destination' => 'required|max:255',
            'checkin'     => 'required|date',
            'checkout'    => 'required|date',
            'adults'      => 'required|min:0',
            'kids'        => 'required|min:0',
            'infants'     => 'required|min:0'
		];
	}

}
