<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProgramService;

class Franchise extends Model  {
	protected $table = 'franchise';

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
        'amount'
    ];

    public function transactions()
    {
        return $this->morphMany('App\Models\Transactions', 'details');
    }
}
