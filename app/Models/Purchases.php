<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Purchases extends AbstractLayer
{
    use SoftDeletes;
   
    protected $table = 'purchases';

    protected $appends = [
        'status_string',
        'status_icon'
        // 'rebatesDetails'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'account_id',
        'purchase_program_services_id',
        'amount',
        'status',
        'branch_id'
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

    const STATUS_ICONS = [
        self::STATUS_PICK_UP   => 'fa-people-carry',
        self::STATUS_CLAIMED   => 'fa-check',
        self::STATUS_SHIPPING  => 'fa-truck',
    ];

    // function getRebatesDetailsAttribute(){

    //     $result = Earnings::where([
    //         'source'=>'rebates',
    //         'purchase_code_id'=>$this->attributes['code_id'],
    //         'account_id'=>$this->attributes['account_id']
    //     ])->get();

    //     return (!$result->isEmpty()) ? $result->first() : null;

    // }

    public function purchaseProducts()
    {
        return $this->hasMany( PurchasesProducts::class, 'purchase_id', 'id');
    }

    public function branch()
    {
        return $this->hasOne( Branches::class, 'id', 'branch_id');
    }

    public function product()
    {
        return $this->hasOne( Products::class, 'id', 'product_id');
    }

    public function getStatusStringAttribute()
    {
        return self::STATUS[$this->status];
    }

    public function getStatusIconAttribute()
    {
        return self::STATUS_ICONS[$this->status];
    }
}