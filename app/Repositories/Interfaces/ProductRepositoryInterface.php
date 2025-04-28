<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Product\StoreImageUpload;

interface ProductRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data , StoreImageUpload $imageRequest);
    public function update($id, array $data ,StoreImageUpload $imageRequest );
    public function delete($id);
}
