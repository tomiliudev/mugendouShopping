<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'information',
        'price',
        'sortOrder',
        'shopId',
        'secondaryId',
        'image1',
        'image2',
        'image3',
        'image4',
        'isSelling',
    ];

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

    public function stocks()
    {
        return $this->hasMany(Stock::class, Stock::FOREIGN_KEY);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'carts')->withPivot(['id', 'quantity']);
    }
}
