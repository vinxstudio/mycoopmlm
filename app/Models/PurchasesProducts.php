<?php 

namespace App\Models;

class PurchasesProducts extends AbstractLayer {

	protected $table = 'purchases_products';

    protected $fillable = [
        'id',
        'purchase_id',
        'product_id',
        'amount',
        'rebates',
        'quantity'
    ];

    /**
     * Gets product.
     *
     * @return string
     */
    public function product()
    {
        return $this->hasOne( Products::class, 'id', 'product_id');
    }
}
