<?php

namespace Tests\Unit;

use App\Http\Requests\Product\StoreImageUpload;
use App\Models\ProductImage;
use App\Service\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     */

    use RefreshDatabase;
    public function test_product_creation_with_multiple_images()
{
    Storage::fake('public');

    $mockRequest = Mockery::mock(StoreImageUpload::class);
    $mockRequest->shouldReceive('hasFile')->with('images')->andReturn(true);
    $mockRequest->shouldReceive('file')->with('images')->andReturn([
        UploadedFile::fake()->image('image1.jpg'),
        UploadedFile::fake()->image('image2.jpg')
    ]);

    $data = [
        'name' => 'Test Product',
        'price' => 100,
        'description' => 'Test Description',
        'quantity' => 10,
    ];

    $service = app()->make(ProductService::class);
    $product = $service->createProduct($data, $mockRequest);
    $product->load('productImages');

    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'price' => 100,
        'description' => 'Test Description',
        'quantity' => 10,
    ]);

    $this->assertEquals(2, ProductImage::where('product_id', $product->id)->count());

    foreach ($product->productImages as $image) {
        Storage::disk('public')->assertExists($image->image_path); // Fixed assertion
    }
}
}
