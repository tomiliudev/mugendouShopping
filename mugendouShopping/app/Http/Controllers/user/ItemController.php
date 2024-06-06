<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Constants\Config;

class ItemController extends Controller implements HasMiddleware
{
    /**
     * コントローラへ指定するミドルウェアを取得
     */
    public static function middleware(): array
    {
        return [
            'auth:user',
            function (Request $request, Closure $next) {

                $id = $request->route()->parameter('product');
                if (!is_null($id)) {
                    $id = (int)$id;
                    if (!Product::availableItems()->where('id', $id)->first()) {
                        abort(404);
                    }
                }
                return $next($request);
            },
        ];
    }

    public function index(Request $request)
    {
        $products = Product::availableItems()
            ->sortOrder($request->sort)
            // ->paginate(12);
            ->get();

        $sortTypeList = [
            Config::SORT_RECOMMEND => 'おすすめ順',
            Config::SORT_HIGHER_PRICE => '高い順',
            Config::SORT_LOWER_PRICE => '安い順',
            Config::SORT_LATER => '新しい順',
            Config::SORT_OLDER => '古い順',
        ];

        return view('user.index', compact('products', 'sortTypeList'));
    }

    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = Stock::where('productId', $product->id)->sum('quantity');
        if ($quantity > 9) {
            $quantity = 9;
        }
        return view('user.show', compact('product', 'quantity'));
    }
}
