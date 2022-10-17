<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\throwException;

class ImageRepositoryInLocal implements ImageRepositoryInterface
{
    public function storeImageDataToStorage($imageData, $path, $fileName)
    {
        $isSuccess = false;
        $isSuccess =  Storage::disk('s3')->put($path + $fileName, $imageData);
        if ($isSuccess) {
            return $path + $fileName;
        } else {
            throw new Exception('画像が保存できませんでした。');
        }
    }

    public function storeImageFileToStorage($path, $imageFile)
    {
        return Storage::disk('s3')->putFile($path, $imageFile);
    }

    public function deleteFromStorage($imagePath)
    {
        return Storage::disk('s3')->delete($imagePath);
    }
}
