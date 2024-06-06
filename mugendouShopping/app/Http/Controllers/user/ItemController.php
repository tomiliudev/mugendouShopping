<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

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

    public function index()
    {
        $products = Product::availableItems()->paginate(12);
        return view('user.index', compact('products'));
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
