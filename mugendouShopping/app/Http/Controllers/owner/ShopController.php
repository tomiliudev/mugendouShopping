<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Closure;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller implements HasMiddleware
{
    /**
     * コントローラへ指定するミドルウェアを取得
     */
    public static function middleware(): array
    {
        return [
            'auth:owner',
            function (Request $request, Closure $next) {
                $shopId = $request->route()->parameter('shop');
                if (!is_null($shopId)) {
                    $shopId = (int)$shopId;
                    if (Shop::findOrFail($shopId)->owner->id !== Auth::id()) {
                        abort(404);
                    }
                }
                return $next($request);
            },
        ];
    }

    public function index()
    {
        phpinfo();
        $ownerId = Auth::id();
        $shopList = Shop::where('ownerId', $ownerId)->get();
        return view('owner.shop.index', compact('shopList'));
    }

    public function edit(Request $request, $id): View
    {
        $shop = Shop::findOrFail($id);
        return view('owner.shop.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $shopImage = $request->image;
        if (!is_null($shopImage) && $shopImage->isValid()) {
            Storage::putFile('public/shop/', $shopImage);
        }

        return redirect()->route('owner.shop.index');
    }
}
