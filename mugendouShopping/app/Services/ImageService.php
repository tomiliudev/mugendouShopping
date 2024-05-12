<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageService
{
    public static function upload($image, $folder)
    {
        // Storage::putFile("public/$folder/", $image); // ファイルオブジェクト
        $resizedImage = ImageManager::gd()->read($image)->resize(1920, 1080)->encode();
        $fileName = uniqid(rand() . '_');
        $extension = $image->extension();
        $uniqFileName = $fileName . '.' . $extension;
        Storage::put("public/$folder/" . $uniqFileName, $resizedImage);
        return $uniqFileName;
    }
}
