<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public const FOREIGN_KEY = 'shopId';

    public function shop()
    {
        return $this->belongsTo(Shop::class, self::FOREIGN_KEY);
    }

    public function imageOne()
    {
        return $this->belongsTo(Image::class, 'image1');
    }

    public function imageTwo()
    {
        return $this->belongsTo(Image::class, 'image2');
    }

    public function imageThree()
    {
        return $this->belongsTo(Image::class, 'image3');
    }

    public function imageFour()
    {
        return $this->belongsTo(Image::class, 'image4');
    }

    public function secondaryCategory()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondaryId');
    }
}
