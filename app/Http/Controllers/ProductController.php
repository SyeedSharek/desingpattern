<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreImageUpload;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Service\ProductService;
use App\Traits\AllResponseApi;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AllResponseApi;
    use ImageUploadTrait;

    protected $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }



    public function index()
    {
        return $this->success($this->service->getAllProduct());
    }

    public function create(StoreProductRequest $storeProductRequest, StoreImageUpload $storeImageUpload)
    {

        return $this->success($this->service->createProduct($storeProductRequest->validated(), $storeImageUpload), "Product created successfully");
    }

    public function show($productId)
    {
        return $this->success($this->service->getProductById($productId));
    }


    public function update(UpdateProductRequest $updateProductRequest, $productId)
    {
        return $this->success($this->service->updateProduct($productId, $updateProductRequest->validated()), "Product updated successfully");
    }

    public function destroy($product_id)
    {
        if ($this->service->deleteProduct($product_id)) {
            return $this->success(null, 'Product and associated images deleted successfully');
        }

        return $this->error('Product not found', 404);
    }
}
