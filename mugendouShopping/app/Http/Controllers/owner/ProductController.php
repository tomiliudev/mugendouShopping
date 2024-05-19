<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Owner;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Shop;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller implements HasMiddleware
{
    /**
     * コントローラへ指定するミドルウェアを取得
     */
    public static function middleware(): array
    {
        return [
            'auth:owner',
            function (Request $request, Closure $next) {
                $id = $request->route()->parameter('product');
                if (!is_null($id)) {
                    $id = (int)$id;
                    if (Product::findOrFail($id)->shop->owner->id !== Auth::id()) {
                        abort(404);
                    }
                }
                return $next($request);
            },
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 単純にリレーションでつなげる場合、where x = で検索するので、数分クエリが実行される
        // $products = Owner::findOrFail(Auth::id())->shop->products;

        // Eager Loadingを使う。関連リレーションをwhere x in ()の形で取得してくるのでN + 1 問題の回避ができる
        $owner = Owner::with('shop.products.imageOne')->findOrFail(Auth::id());
        $products = $owner->shop->products ?? collect();
        return view('owner.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shops = Shop::where('ownerId', Auth::id())
            ->select(['name'])->get();

        $images = Image::where('ownerId', Auth::id())
            ->select(['id', 'imageName'])->get();

        $categories = PrimaryCategory::with('secondaryCategories')->get();

        return view('owner.product.create', compact('shops', 'images', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd("商品登録");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
