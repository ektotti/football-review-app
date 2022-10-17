<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Storage;

class ImageRepositoryInLocal implements ImageRepositoryInterface
{
    public function storeImageDataToStorage($imageData, $path, $fileName)
    {
        $isSuccess = false;
        $isSuccess =  Storage::disk('public')->put($path.$fileName, $imageData);
        if ($isSuccess) {
            return $path.$fileName;
        } else {
            throw new Exception('画像が保存できませんでした。');
        }
    }

    public function storeImageFileToStorage($path, $imageFile)
    {
        return Storage::disk('public')->putFile($path, $imageFile);
    }

    public function deleteFromStorage($imagePath)
    {
        return Storage::disk('public')->delete($imagePath);
    }
}
