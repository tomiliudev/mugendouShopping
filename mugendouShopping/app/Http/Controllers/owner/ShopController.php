<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Shop;
use App\Services\ImageService;
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

    public function edit(Request $request, $id): View
    {
        $shop = Shop::findOrFail($id);
        return view('owner.shop.edit', compact('shop'));
    }

    public function update(UploadImageRequest $request, $id)
    {
        $shopImage = $request->image;
        if (!is_null($shopImage) && $shopImage->isValid()) {
            $uniqFileName = ImageService::upload($shopImage, 'shop');

            $shop = Shop::findOrFail($id);
            $shop->imageName = $uniqFileName;
            $shop->save();
        }

        return redirect()->route('owner.shop.index');
    }
}
