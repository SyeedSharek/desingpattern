<?php

namespace App\Service;

use App\Http\Requests\Product\StoreImageUpload;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $ProductRepositoryInterface)
    {
        $this->productRepo = $ProductRepositoryInterface;
    }

    public function getAllProduct()
    {
        return $this->productRepo->all();
    }

    public function getProductById($id)
    {
        return $this->productRepo->find($id);
    }

    public function createProduct(array $data , StoreImageUpload $imageRequest)
    {
        return $this->productRepo->create($data, $imageRequest);
    }

    public function updateProduct($id, array $data , StoreImageUpload $imageRequest)
    {
        return $this->productRepo->update($id, $data , $imageRequest);
    }

    public function deleteProduct($id)
    {
        return $this->productRepo->delete($id);
    }
}
