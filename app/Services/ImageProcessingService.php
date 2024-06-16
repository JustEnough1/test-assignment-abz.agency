<?php

namespace App\Services;

use Tinify\Tinify;

class ImageProcessingService
{

    public function __construct()
    {
        Tinify::setKey(env('TINIFY_API_KEY'));
    }

    // Image compression and resizing
    function optimizeImage($image)
    {
        $fileName =  uniqid() . '.jpg';
        $path = storage_path('app/public/images/') . $fileName;

        $sourceImage = $this->compressImage($image);
        $resizedImage = $this->resizeImage($sourceImage);

        $resizedImage->toFile($path); // save file
        return $fileName;
    }

    function compressImage($image)
    {
        $source = \Tinify\fromBuffer(file_get_contents($image));
        return $source;
    }

    // Crop image 70x70 px 
    function resizeImage($source)
    {
        $resizedImage = $source->resize(
            [
                "method" => "cover",
                "width" => 70,
                "height" => 70
            ]
        );
        return $resizedImage;
    }
}
