<?php 

namespace App\Models;

class Products extends AbstractLayer {

	protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'price',
        'rebates',
        'points_value',
        'description',
        'image',
        'publish',
        'package',
        'category',
        'slug'
    ];

    protected $appends = [
        'purchaseValue',
        'category_string'
    ];

    const PACKAGE  = 0;
    const SINGLE   = 1;
    const TYPES    = [
        self::PACKAGE => 'Package',
        self::SINGLE  => 'Single'
    ];

    const COSMETICS  = 0;
    const HEALTH     = 1;
    const CATEGORIES = [
        self::COSMETICS => 'Cosmetics',
        self::HEALTH    => 'Health',
    ];

    function unilevel()
    {
        return $this->hasMany($this->namespace . '\ProductUnilevel', 'product_id', 'id');
    }

    function getPurchaseValueAttribute()
    {
        $charge = (int)config('system.purchase_codes_charge');
        $price  = $this->attributes['price'];

        if ($charge > 0) {
            $price = $price + (($charge/100)*$price);
        }

        return $price;
    }

    /**
     * Gets all published products for ecommerce listing.
     *
     * @param string $order
     * @param string $sort
     *
     * @return Products[]
     */
    public function getFrontendProducts($order, $sort, $category)
    {
        $paginate = 10;
        $order    = $order? $order: 'name';
        $sort     = $sort? $sort: 'asc';
        $category = $category? $category: null;
        $products = $this->select(['slug', 'image', 'name', 'price', 'rebates', 'id'])->where(['publish' => 1]);
            
        if ($category) {
            $products->where(['category' => $category]);
        }

        return $products
            ->orderBy($order, $sort)
            ->paginate($paginate)->appends(['order' => $order, 'sort' => $sort, 'category' => $category]);
    }

    /**
     * Gets string value of product category.
     *
     * @return string
     */
    public function getCategoryStringAttribute()
    {
        return self::CATEGORIES[$this->category];
    }
}
