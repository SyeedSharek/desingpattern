<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_product_price_calculation()
    {
        $product = new Product();
        $product->price = 100;
        $product->discount = 10;

        $finalPrice = $product->price - $product->discount;

        $this->assertEquals(90, $finalPrice);
    }
}
