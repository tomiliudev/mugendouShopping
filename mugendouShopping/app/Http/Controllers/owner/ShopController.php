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
        $request->validate(
            [
                'name' => ['required', 'string', 'max:50'],
                'information' => ['required', 'string', 'max:1000'],
                'isEnable' => ['required'],
            ]
        );

        $name = $request->name;
        $information = $request->information;
        $isEnable = $request->isEnable;
        $shopImage = $request->uploadImage;

        // shop情報取得
        $shop = Shop::findOrFail($id);

        if (!is_null($shopImage) && $shopImage->isValid()) {
            $folder = 'shop';

            // 既存の画像を削除
            if (!empty($shop->imageName)) {
                ImageService::delete($shop->imageName, $folder);
            };

            // 新しい画像で更新
            $uniqFileName = ImageService::upload($shopImage, $folder);
            $shop->imageName = $uniqFileName;
        }

        $shop->name = $name;
        $shop->information = $information;
        $shop->isEnable = $isEnable;
        $shop->save();

        return redirect()->route('owner.shop.index')
            ->with([
                'message' => '店舗情報を更新しました。',
                'status' => 'info'
            ]);
    }
}
