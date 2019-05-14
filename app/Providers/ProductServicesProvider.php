<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

use App\Models\ProgramService;
use App\Models\Transactions;
use App\Models\Products;

class ProductServicesProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers\ProgramServices';

    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('programServiceSlug', function($programServiceSlug)
        {
            return ProgramService::where(['slug' => $programServiceSlug])->first();
        });

        $router->bind('productSlug', function($productSlug){
            return Products::where(['slug' => $productSlug])->first();
        });

        $router->model('transaction', Transactions::class);
    }
    
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/product_services_routes.php');
        });
    }
}