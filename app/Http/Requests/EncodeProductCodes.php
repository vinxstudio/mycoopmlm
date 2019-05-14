<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\PurchaseCodes;

class EncodeProductCodes extends Request
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{

		return true;
		
		#if (!$this->has('product_code'))
		#	return false;

		#$product_code = PurchaseCodes::where('code', $this->product_code)->first();

		#if ($product_code == null || $product_code->isEmpty())
		#	return false;

		#return ($product_code->owner_id == auth()->user()->id);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'product_code' => 'required|exists:product_purchase_codes,code',
			'product_code_password' => 'required',
			'account_id' => 'required'
		];
	}

	public function messages()
	{
		return [
			'product_code.exists' => 'The product code is invalid',
		];
	}

}
