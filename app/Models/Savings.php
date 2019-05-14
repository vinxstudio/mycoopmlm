<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProgramService;

class Savings extends Model  {
	protected $table = 'savings';

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'requester_id',
        'last_name',
        'first_name',
        'middle_name',
        'birthdate',
        'contact_number',
        'home_address',
        'type',
        'type_string',
        'amount'
    ];

    /**
     * @var array
     */
    protected $dates = ['publish_date'];

    /**
     * @var constants
     */
    const TYPE_REGULAR      = '1';
    const TYPE_KIDDIE       = '2';
    const TYPE_PISO_TIGUM   = '3';
    const TYPE_TIME_DEPOSIT = '4';
    const TYPE_SAVED        = '5';
    const TYPE_CESPP        = '6';
    const TYPE_PPI          = '7';
    const TYPES = [
	    self::TYPE_REGULAR      => 'Regular Savings',
	    self::TYPE_KIDDIE       => 'Kiddie Savings',
	    self::TYPE_PISO_TIGUM   => 'PISO-PISO Tigum',
	    self::TYPE_TIME_DEPOSIT => 'Time Deposit',
	    self::TYPE_SAVED        => 'Saved Savings',
	    self::TYPE_CESPP        => 'CESPP (College Education Savings Plus Program',
	    self::TYPE_PPI          => 'PEOPLES PREFFERED INVESTMENT (PPI)'
    ];

    /**
     * Gets amount of savings depending on SELF::TYPES
     *
     * @param int $type
     *
     * @return integer
     */
    public static function getAmountByType($type)
    {
        $cost          = ProgramService::where(['name' => 'Savings'])->first(['cost']);
        $chunks        = array_chunk(preg_split('/(-|,)/', $cost), 2);
        $formattedCost = array_combine(array_column($chunks, 0), array_column($chunks, 1));

        return (isset($formattedCost[$type])? $formattedCost[$type]: 0);
    }

    public function transactions()
    {
        return $this->morphMany('App\Models\Transactions', 'details');
    }

    public function getTypeStringAttribute()
    {
        return self::TYPES[$this->type];
    }

}
