<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Damayan extends Model {
	protected $table = 'damayan';

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
        'address',
        'beneficiary',
        'type',
        'cost',
        'range'
    ];

    protected $appends = [
        'type_string',
        'range_details',
        'range_amount'
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var constants
     */
    const TYPE_NEW     = '1';
    const TYPE_RENEWAL = '2';
    const TYPES = [
        self::TYPE_NEW     => 'New',
        self::TYPE_RENEWAL => 'Renewal'
    ];


    const RANGE_18_60                          = 0;
    const RANGE_61_68                          = 1;
    const RANGE_69_ABOVE_RENEWAL               = 2;
    const RANGE_69_ABOVE_RENEWAL_CONTESTABILIY = 3;

    const RANGES = [
        self::RANGE_18_60 => [
            'amount'  => 800.00,
            'details' => 'Ages 18 to 60'
        ],
        self::RANGE_61_68 => [
            'amount'  => 1500.00,
            'details' => 'Ages 61 to 68'
        ],
        self::RANGE_69_ABOVE_RENEWAL => [
            'amount'  => 1400.00,
            'details' => 'Ages 69 and above (Renewal Only)'
        ],
        self::RANGE_69_ABOVE_RENEWAL_CONTESTABILIY => [
            'amount'  => 1250.00,
            'details' => 'Ages 69 and above (Renewal Only with 5 Years COntestability)'
        ],
    ];

    public function transactions()
    {
        return $this->morphMany('App\Models\Transactions', 'details');
    }

    public function getTypeStringAttribute()
    {
        return self::TYPES[$this->type];
    }

    public function getRangeDetailsAttribute()
    {
        return self::RANGES[$this->range]['details'];
    }

    public function getRangeAmountAttribute()
    {
        return self::RANGES[$this->range]['amount'];
    }
}
