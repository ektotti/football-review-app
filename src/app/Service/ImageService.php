<?php

namespace App\Service;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ImageRepositoryInterface;

class ImageService
{
    public $imageRepository;

    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function saveImagesAndGetImagePath($path, $imageDataUrls) {
        $imageData = $this->makeImageDataFromDataurl($imageDataUrls);
        return $this->storeImageDataToStorage($path, $imageData);
    }

    public function makeImageDataFromDataurl($imageDataUrls)
    {
        $imageData = [];
        for ($i = 0; $i < count($imageDataUrls); $i++) {
            $imageDataUrl = $imageDataUrls[$i];
            $imageDataUrl = preg_replace("/data\:image\/jpeg\;base64,/", '', $imageDataUrl);
            array_push($imageData, base64_decode($imageDataUrl));
        }
        return $imageData;
    }

    public function storeImageDataToStorage($path, $imageData)
    {
        $imagePath = [];
        foreach ($imageData as $data) {
            $fileName = Uuid::uuid4() . '.jpeg';
            array_push($imagePath, $this->imageRepository->storeImageDataToStorage($data, $path, $fileName));
        }
        return $imagePath;
    }

    public function deleteFromStorage($imagePath) {
        return $this->imageRepository->deleteFromStorage($imagePath);
    }
}
