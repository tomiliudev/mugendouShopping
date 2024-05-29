<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        // shop.isEnable = true
        // product.isSelling = true
        // 在庫が1以上
        $stocks = DB::table('t_stocks')->select('productId', DB::raw('sum(quantity) as quantity'))->groupBy('productId')->having('quantity', '>', 0)->get();
        $productIds = array_column($stocks->toArray(), 'productId');
        $shops = Shop::select('id')->where('isEnable', 1)->get();
        $shopIds = array_column($shops->toArray(), 'id');
        $products = Product::with(['imageOne', 'imageTwo', 'imageThree', 'imageFour', 'secondaryCategory', 'stocks'])
            ->whereIn('id', $productIds)
            ->whereIn('shopId', $shopIds)
            ->where('isSelling', 1)
            ->paginate(12);

        return view('user.index', compact('products'));
    }
}
