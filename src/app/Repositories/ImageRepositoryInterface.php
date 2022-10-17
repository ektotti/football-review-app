<?php
namespace App\Repositories;

interface ImageRepositoryInterface {
    public function storeImageDataToStorage($imageData, $path, $fileName);
    public function storeImageFileToStorage($path, $imageFile);
    public function deleteFromStorage($imagePath);
}