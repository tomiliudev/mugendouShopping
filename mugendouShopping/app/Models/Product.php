<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Constants\Config;

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
        return $this->belongsToMany(User::class, 'carts', 'productId', 'userId')->withPivot(['id', 'quantity']);
    }

    // ローカルスコープ
    public function scopeAvailableItems($query)
    {
        // shop.isEnable = true
        // product.isSelling = true
        // 在庫が1以上
        $stocks = DB::table('t_stocks')->select('productId', DB::raw('sum(quantity) as quantity'))->groupBy('productId')->having('quantity', '>', 0)->get();
        $productIds = array_column($stocks->toArray(), 'productId');
        $shops = Shop::select('id')->where('isEnable', 1)->get();
        $shopIds = array_column($shops->toArray(), 'id');
        return Product::with(['imageOne', 'imageTwo', 'imageThree', 'imageFour', 'secondaryCategory', 'stocks'])
            ->whereIn('id', $productIds)
            ->whereIn('shopId', $shopIds)
            ->where('isSelling', 1);
    }

    public function scopeSortOrder($query, $sort)
    {
        switch ($sort) {
            case Config::SORT_HIGHER_PRICE:
                return $query->OrderBy('price', 'desc');
                break;
            case Config::SORT_LOWER_PRICE:
                return $query->OrderBy('price', 'asc');
                break;
            case Config::SORT_LATER:
                return $query->OrderBy('created_at', 'desc');
                break;
            case Config::SORT_OLDER:
                return $query->OrderBy('created_at', 'asc');
                break;
            case Config::SORT_RECOMMEND:
            default:
                return $query->OrderBy('sortOrder', 'asc');
                break;
        }
    }

    public function scopeCategory($query, $category)
    {
        if (!$category) return $query;
        return $query->where('secondaryId', $category);
    }
}
