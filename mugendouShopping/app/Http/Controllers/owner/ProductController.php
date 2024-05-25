<?php

namespace App\Http\Controllers\Owner;

use App\Constants\Config;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\ProductRequest;
use App\Models\Image;
use App\Models\Owner;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Stock;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            ->select(['id', 'name'])->get();

        $images = Image::where('ownerId', Auth::id())
            ->select(['id', 'imageName'])->get();

        $categories = PrimaryCategory::with('secondaryCategories')->get();

        return view('owner.product.create', compact('shops', 'images', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'sortOrder' => $request->sortOrder,
                    'shopId' => $request->shopId,
                    'secondaryId' => $request->secondaryId,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'isSelling' => $request->isSelling,
                ]);

                Stock::create([
                    'productId' => $product->id,
                    'type' => 1,
                    'quantity' => $request->quantity,
                ]);
            });
        } catch (\Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()->route('owner.products.index')->with(['message' => '商品を登録しました。', 'status' => 'info']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('productId', $product->id)->sum('quantity');

        $shops = Shop::where('ownerId', Auth::id())
            ->select(['id', 'name'])->get();

        $images = Image::where('ownerId', Auth::id())
            ->select(['id', 'imageName'])->get();

        $categories = PrimaryCategory::with('secondaryCategories')->get();

        return view('owner.product.edit', compact('product', 'quantity', 'shops', 'images', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $request->validate([
            'current_quantity' => ['integer', 'required'],
        ]);

        $product = Product::findOrFail($id);
        $quantity = Stock::where('productId', $product->id)->sum('quantity');

        $current_quantity = (int)$request->current_quantity;
        if ($quantity != $current_quantity) {
            return redirect()->route('owner.products.edit', ['product' => $id])
                ->with(['message' => '現在の在庫数が変わりました。ご確認ください。', 'status' => 'warning']);
        } else {
            try {
                DB::transaction(function () use ($request, $product) {
                    $product->shopId = $request->shopId;
                    $product->name = $request->name;
                    $product->information = $request->information;
                    $product->price = $request->price;
                    $product->isSelling = $request->isSelling;
                    $product->sortOrder = $request->sortOrder;
                    $product->secondaryId = $request->secondaryId;
                    $product->image1 = $request->image1;
                    $product->image2 = $request->image2;
                    $product->image3 = $request->image3;
                    $product->image4 = $request->image4;
                    $product->save();

                    $quantityType = (int)$request->quantityType;
                    $quantity = $request->quantity;
                    if ($quantityType > 0 && $quantity > 0) {
                        if ($quantityType == Config::PRODUCT_REDUCE) $quantity = $quantity * -1;

                        Stock::create([
                            'productId' => $product->id,
                            'type' => $quantityType,
                            'quantity' => $quantity,
                        ]);
                    }
                });
            } catch (\Throwable $e) {
                Log::error($e);
                throw $e;
            }
        }

        return redirect()->route('owner.products.index')
            ->with(['message' => '商品情報を更新しました。', 'status' => 'info']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
