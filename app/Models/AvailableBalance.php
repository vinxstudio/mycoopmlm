<?php namespace App\Models;

class AvailableBalance extends AbstractLayer
{

	protected $table = 'available_balance';


	const SOURCE_REDUNDANT_BINARY_INCOME = 'redundant_binary_income';
	const SOURCE_TOTAL_INCOME = 'available_balance';


	protected $fillable = ['group_id', 'source'];
}
