<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Constants\Config;
use App\Models\PrimaryCategory;

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
            ->category($request->category)
            ->keyword($request->keyword)
            ->sortOrder($request->sort)
            ->paginate($request->pagination ?? Config::PAGINATION_12);

        $sortTypeList = [
            Config::SORT_RECOMMEND => 'おすすめ順',
            Config::SORT_HIGHER_PRICE => '高い順',
            Config::SORT_LOWER_PRICE => '安い順',
            Config::SORT_LATER => '新しい順',
            Config::SORT_OLDER => '古い順',
        ];

        $paginationList = [
            Config::PAGINATION_12 => '１２件',
            Config::PAGINATION_24 => '２４件',
            Config::PAGINATION_36 => '３６件',
            Config::PAGINATION_48 => '４８件',
            Config::PAGINATION_60 => '６０件',
        ];

        $categoryList = PrimaryCategory::with('secondaryCategories')->get();

        return view('user.index', compact('products', 'categoryList', 'sortTypeList', 'paginationList'));
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
