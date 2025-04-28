<?php
namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class ProductServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'product-service';
    }
}
