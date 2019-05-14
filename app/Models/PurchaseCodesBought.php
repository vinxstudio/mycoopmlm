<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PurchaseCodesBought extends Model
{

	//
	protected $table = 'purchase_codes_boughts';

	# purchase_id
	# product_id
	# product_code

	function getPurchase()
	{
		return $this->hasOne(Purchases::class, 'id', 'purchase_id');
	}

	function getProduct()
	{
		return $this->hasOne(Products::class, 'id', 'product_id');
	}

	function getProductCodes()
	{
		return $this->hasOne(PurchaseCodes::class, 'code', 'product_code');
	}

}
