<?php

namespace App\Repositories\Eloquent;

use App\Http\Requests\Product\StoreImageUpload;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Traits\ImageUploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductRepositoryInterface
{
    use ImageUploadTrait;

    public function all()
    {
        return Product::latest()->get();
    }

    public function find($id)
    {
        return Product::find($id);
    }
    public function create(array $data, StoreImageUpload $imageRequest)
    {
        DB::beginTransaction();

        try {

            $product = Product::create($data);


            $images = $this->multipleImageUpload($imageRequest, 'images', 'products');

            foreach ($images as $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                ]);
            }

            DB::commit();

            return $product;
        } catch (Exception $e) {

            DB::rollBack();

            // Log::error('Product creation failed: ' . $e->getMessage());
            Log::error('Product creation failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());


            throw new Exception("Product creation failed. Please try again.");
        }
    }
    public function update($id, array $data, StoreImageUpload $imageRequest)
    {
        $product = Product::with('productImages')->find($id);

        if (!$product) {
            return false;
        }

        DB::beginTransaction();

        try {

            $product->update($data);

            foreach ($product->productImages as $image) {
                $this->deleteImage($image->image_path);
                $image->delete();
            }

            $images = $this->multipleImageUpload($imageRequest, 'images', 'products');

            foreach ($images as $imagePath) {
                $product->productImages()->create([
                    'image_path' => $imagePath,
                ]);
            }
            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error("Product update failed: " . $e->getMessage());
            throw new \Exception("Product update failed. Please try again.");
        }
    }

    public function delete($id)
    {
        $product = Product::with('productImages')->find($id);

        if ($product) {
            // Delete images from storage
            foreach ($product->productImages as $image) {
                $this->deleteImage($image->image_path);
                $image->delete(); // Delete image record from DB
            }

            // Delete the product
            $product->delete();

            return true;
        }

        return false;
    }
}
