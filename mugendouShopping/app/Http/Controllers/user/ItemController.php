<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller implements HasMiddleware
{
    /**
     * コントローラへ指定するミドルウェアを取得
     */
    public static function middleware(): array
    {
        return [
            'auth:user',
            // function (Request $request, Closure $next) {
            //     $id = $request->route()->parameter('product');
            //     if (!is_null($id)) {
            //         $id = (int)$id;
            //         if (Product::findOrFail($id)->shop->owner->id !== Auth::id()) {
            //             abort(404);
            //         }
            //     }
            //     return $next($request);
            // },
        ];
    }

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

    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('user.show', compact('product'));
    }
}
