<?php

/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/8/17
 * Time: 9:47 PM
 */

namespace App\Models;

class ProductIncentives extends AbstractLayer
{

    protected $table = 'product_incentive';
    protected $account_id;

    public function getInventives($account_id = null)
    {
        return $this->select('product_incentive.product_purchase_id', 'product_incentive.purchase_product_id', 'product_incentive.sponsor_id', 'product_incentive.amount', 'product_incentive.created_at', 'user_details.first_name', 'user_details.last_name', 'purchases_products.amount as prod_amount', 'purchases_products.rebates', 'purchases_products.quantity', 'product_purchase.type', 'product_purchase.payors_name')
            ->leftJoin('accounts', 'accounts.id', '=', 'product_incentive.account_id')
            ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
            ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
            ->leftJoin('purchases_products', 'purchases_products.id', '=', 'product_incentive.purchase_product_id')
            ->leftJoin('product_purchase', 'product_purchase.id', '=', 'product_incentive.product_purchase_id')
            ->where('product_incentive.sponsor_id', '=', $account_id)
            ->orderBy('created_at', 'DESC')
            ->get();
                    // ->orderBy('user_details.first_name', 'ASC');

    }
}