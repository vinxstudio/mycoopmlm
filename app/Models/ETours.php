<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProgramService;

class ETours extends Model  {
	protected $table = 'etours';

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'requester_id',
        'destination',
        'checkin',
        'checkout',
        'adults',
        'kids',
        'infants',
        'type',
        'type_string'
    ];

    /**
     * @var constants
     */
    const TYPE_FOOD        = '1';
    const TYPE_STAYCATION  = '2';
    const TYPE_MULTI_DAY   = '3';
    const TYPE_DAY         = '4';
    const TYPE_EDUCATIONAL = '5';
    const TYPE_CORPORATE   = '6';

    const TYPES = [
	    self::TYPE_FOOD        => 'Food Tours',
	    self::TYPE_STAYCATION  => 'Staycations',
	    self::TYPE_MULTI_DAY   => 'Multi-day Tours',
	    self::TYPE_DAY         => 'Day Tours',
        self::TYPE_EDUCATIONAL => 'Educational',
        self::TYPE_CORPORATE   => 'Corporate Travel',
    ];

    public function transactions()
    {
        return $this->morphMany('App\Models\Transactions', 'details');
    }

    public function getTypeStringAttribute()
    {
        return self::TYPES[$this->type];
    }

}
