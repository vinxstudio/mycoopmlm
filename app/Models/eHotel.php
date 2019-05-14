<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProgramService;

class EHotel extends Model  {
	protected $table = 'ehotel';

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'requester_id',
        'destination',
        'checkin',
        'checkout',
        'room',
        'guest'
    ];

    public function transactions()
    {
        return $this->morphMany('App\Models\Transactions', 'details');
    }
}
