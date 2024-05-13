<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageService
{
    private const PATH = "public/%s/";

    public static function upload($image, $folder)
    {
        // Storage::putFile("public/$folder/", $image); // ファイルオブジェクト
        $resizedImage = ImageManager::gd()->read($image)->resize(1920, 1080)->encode();
        $fileName = uniqid(rand() . '_');
        $extension = $image->extension();
        $uniqFileName = $fileName . '.' . $extension;
        Storage::put(sprintf(self::PATH, $folder) . $uniqFileName, $resizedImage);
        return $uniqFileName;
    }

    public static function delete($image, $folder)
    {
        $filePath = sprintf(self::PATH, $folder) . $image;
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }
}
