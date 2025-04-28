<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

trait ImageUploadTrait
{

    public function ProcessImage(UploadedFile $file, string $directory, ?string $exitsFilePath = null): ?string
    {
        if (!$file->isValid()) {
            return null;
        }

        if ($exitsFilePath) {
            Storage::disk('public')->delete($exitsFilePath);
        }

        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }


        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "{$directory}/{$fileName}";
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $image->save(storage_path("app/public/{$path}"), progressive: true, quality: 70);
        return $path;
    }




    public function singleImageUpload($request, string $fileName, string $path = 'images', ?string $exitsFilePath = null): ?string
    {

        if (!$request->hasFile($fileName)) {
            return null;
        }

        $file = $request->file($fileName);

        if (!$file instanceof UploadedFile || !$file->isValid()) {
            return null;
        }

        return $this->ProcessImage($file, $path, $exitsFilePath);
    }

    // public function multipleImageUpload($request, string $fileName, string $directory = 'images'): array
    // {

    //     if(!$request->hasFile($fileName)){
    //         return [];
    //     }

    //     $imagePaths = [];
    //     foreach ($request->file($fileName) as $file){
    //         $imagePath = $this->ProcessImage($file, $directory);
    //         if($imagePath){
    //             $imagePaths[] = $imagePath;
    //         }
    //     }

    //     return $imagePaths;

    // }

    public function multipleImageUpload($request, $inputName, $storagePath)
{
    $uploadedPaths = [];

    if ($request->hasFile($inputName)) {
        foreach ($request->file($inputName) as $file) {
            $path = $file->store($storagePath, 'public');
            $uploadedPaths[] = $path; // This will be the full path including directory
        }
    }

    return $uploadedPaths;
}

    public function deleteImage(?string $image): void
    {
        if ($image) {
            Storage::disk('public')->delete($image);
        }
    }
}
