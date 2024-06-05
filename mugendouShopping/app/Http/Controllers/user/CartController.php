<?php

namespace App\Http\Controllers\user;

use App\Constants\Config;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller implements HasMiddleware
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
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        return view('user.cart', compact('products', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'productId' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:9'],
        ]);

        $userId = Auth::id();
        $productId = $request->productId;
        $quantity = $request->quantity;

        $product = Cart::where('userId', $userId)->where('productId', $productId)->first();
        if ($product) {
            $product->quantity += $quantity;
            $product->save();
        } else {
            Cart::create([
                'userId' => $userId,
                'productId' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with(['message' => 'カートに追加しました。', 'status' => 'info']);
    }

    public function delete($id)
    {
        Cart::where('productId', $id)->where('userId', Auth::id())->delete();
        return redirect()->route('cart.index')->with(['message' => '商品をカートから削除しました。', 'status' => 'warning']);
    }

    public function checkout()
    {
        // カートにあるアイテムの取得
        $products = User::findOrFail(Auth::id())->products;

        $lineItems = [];
        foreach ($products as $product) {
            $quantity = Stock::where('productId', $product->id)->sum('quantity');

            if ($product->pivot->quantity > $quantity) {
                // カートにある数　>　在庫数なら「カート」画面へリダイレクト
                return redirect()->route('cart.index')->with(['message' => $product->name . 'が在庫不足です。', 'status' => 'warning']);
            } else {
                // 在庫数が足りる場合、stripeで必要な情報を生成
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $product->name,
                            'description' => $product->information,
                            // 'images' => [
                            // asset('storage/product/' . $product->imageOne->imageName),
                            // asset('storage/product/' . $product->imageTwo->imageName),
                            // asset('storage/product/' . $product->imageThree->imageName),
                            // asset('storage/product/' . $product->imageFour->imageName),
                            // ]
                        ],
                        'unit_amount' => $product->price
                    ],
                    'quantity' => $product->pivot->quantity
                ];
            }
        }

        // 在庫数を減らしておく
        $this->saveStock($products, Config::PRODUCT_REDUCE);

        // stripeのcheckout処理
        $stripe = new \Stripe\StripeClient(env('STRIPE_TEST_SECRET_KEY'));
        $session = $stripe->checkout->sessions->create([
            'line_items' => [
                $lineItems
            ],
            'currency' => 'jpy',
            'mode' => 'payment',
            'success_url' => route('cart.success'),
            'cancel_url' => route('cart.cancel'),
        ]);

        $publicKey = env('STRIPE_TEST_PUBLIC_KEY');

        return view('user.checkout', compact('session', 'publicKey'));
    }

    public function success()
    {
        Cart::where('userId', Auth::id())->delete();
        return redirect()->route('item.index');
    }

    public function cancel()
    {
        // カートにあるアイテムの取得
        $products = User::findOrFail(Auth::id())->products;

        // 在庫数を戻す
        $this->saveStock($products, Config::PRODUCT_ADD);

        return redirect()->route('cart.index');
    }

    private function saveStock($products, $type)
    {
        foreach ($products as $product) {
            $quantity = $product->pivot->quantity;
            if ($type == Config::PRODUCT_REDUCE) $quantity = $quantity * -1;
            Stock::create([
                'productId' => $product->id,
                'type' => $type,
                'quantity' => $quantity
            ]);
        }
    }
}
