<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/10/17
 * Time: 12:16 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;

class Transactions extends AbstractLayer
{
    use SoftDeletes;
   
    protected $table = 'transactions';
    
    /**
     * @var array
     */
    protected $fillable = [
        'requester_id',
        'requester',
        'account_id',
        'savings_id',
        'cost',
        'amount',
        'status',
        'status_string',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var constants
     */
    const STATUS_PENDING  = '1';
    const STATUS_PAID     = '2';
    const STATUS_SHIPPING = '3';
    const STATUS_PICK_UP  = '4';
    const STATUS_CLAIMED  = '5';
    const STATUS_APPROVED = '6';

    const STATUS = [
        self::STATUS_PENDING   => 'Pending',
        self::STATUS_PAID      => 'Paid',
        self::STATUS_SHIPPING  => 'For Shipping',
        self::STATUS_PICK_UP   => 'For Pick-up',
        self::STATUS_CLAIMED   => 'Claimed',
        self::STATUS_APPROVED  => 'Approved'
    ];

    /**
     * Morphs details_id and details_type into associated model.
     */
    public function details()
    {
        return $this->morphTo();
    }

    /**
     * Gets paginated result of user's transaction.
     *
     * @return Transactions[]
     */
    public function getUserPaginatedList()
    {
        return $this->where([
            'requester_id' => Auth::user()->id, 
            'account_id'   => Auth::user()->account->id
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    }

    /**
     * Gets all transaction
     *
     * @return Transactions[]
     */
    public function getAllPaginatedList()
    {
        return $this->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Gets string value of status.
     *
     * @return string
     */
    public function getStatusStringAttribute()
    {
        return self::STATUS[$this->status];
    }

    /**
     * Gets string value of requester id.
     *
     * @return string
     */
    public function getRequesterAttribute()
    {
        return User::find($this->requester_id)->first()->username;
    }
}