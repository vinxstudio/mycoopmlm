<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/25/16
 * Time: 9:18 PM
 */

namespace App\Http\TraitLayer;

use App\Models\Products;

trait ProductsTrait{

    function getProductsList($withPrice = false){
        $products = Products::all();
        $dropdown = [];
        $completeDetails = [];
        $charge = (int)config('system.purchase_codes_charge');

        foreach ($products as $product){
            $productPrice = ($charge > 0) ? ($product->price + ($charge/100)*$product->price) : $product->price;
            $suffix = ($withPrice == true) ? sprintf('(%s)', number_format($productPrice, 2)) : null;
            $dropdown[$product->id] = sprintf('%s %s', $product->name, $suffix);
            $completeDetails[$product->id] = $product;
        }

        $result = new \stdClass();
        $result->dropdown = $dropdown;
        $result->completeDetails = $completeDetails;
        return $result;
    }

}