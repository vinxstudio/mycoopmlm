<?php 

namespace App\Models;

class PurchaseCodes extends AbstractLayer
{

    protected $table = 'product_purchase_codes';

    protected $appends = ['theStatus'];

    protected $fillable = [
        'product_id',
        'code',
        'password',
        'status',
        'owner_id',
        'purchase_value'
    ];

    /**
     * @var constants
     */
    const STATUS_UNUSED = '0';
    const STATUS_USED = '1';
    const STATUS_TRANSFERED = '2';
    const STATUS_ACTIVATED = '3';
    const STATUS = [
        self::STATUS_UNUSED => 'available',
        self::STATUS_USED => 'used',
        self::STATUS_TRANSFERED => 'transfered',
        self::STATUS_ACTIVATED => 'activated',
        null => null
    ];

    /**
     * 
     * @var Product_Type_Constant
     * 
     *  */

    const PRODUCT_TYPE_SRP = 'SRP';
    const PRODUCT_TYPE_MEMBERS_PRICE = 'Members Price';
    const PRODUCT_TYPE = [
        self::PRODUCT_TYPE_SRP => 'Suggested Retail Price (SRP)',
        self::PRODUCT_TYPE_MEMBERS_PRICE => 'Members Price (MP)'
    ];

    function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }

    function getTheStatusAttribute()
    {
        return self::STATUS[$this->attributes['status']];
    }
}
