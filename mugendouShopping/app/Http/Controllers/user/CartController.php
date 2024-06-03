<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
}
