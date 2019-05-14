<?php 

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DamayanRequest extends Request {

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
			'last_name'   => 'required|max:255',
            'first_name'  => 'required|max:255',
            'middle_name' => 'required|max:255',
            'beneficiary' => 'required|max:255',
            'birthdate'   => 'required|date',
            'address'     => 'required|max:255',
            'type'        => 'required'
		];
	}

}
