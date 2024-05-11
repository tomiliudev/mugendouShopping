<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\RedirectResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

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
        $ownerId = Auth::id();
        $shopList = Shop::where('ownerId', $ownerId)->get();
        return view('owner.shop.index', compact('shopList'));
    }

    public function edit(Request $request, $shopId): View
    {
        dd($request->route()->parameter('shop'));
    }

    public function update(Request $request): RedirectResponse
    {
        dd("shop update");
    }
}
