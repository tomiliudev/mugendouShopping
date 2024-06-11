<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MailService
{
    public static function getMailInfos()
    {
        $mailInfos = [];
        $user = User::findOrFail(Auth::id());
        $itemsInCart = Cart::where('userId', Auth::id())->get();

        //オーナー情報、ショップ情報、商品情報
        foreach ($itemsInCart as $item) {
            $productId = $item->productId;
            $product = Product::select('id', 'name', 'price', 'shopId', 'image1')->where('id', $productId)->first();
            $shop = $product->shop;
            $image = $product->imageOne;
            $owner = $shop->owner;

            $shopId = $shop->id;
            $shopInfo = [
                'shop' => [
                    'id' => $shopId,
                    'name' => $shop->name,
                ],
                'owner' => [
                    'id' => $owner->id,
                    'name' => $owner->name,
                    'email' => $owner->email,
                ],
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ];

            $productInfo = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $image->imageName,
                'quantity' => $item->quantity,
            ];

            $mailInfos[$shopId]['shopInfo'] = $shopInfo;
            $mailInfos[$shopId]['productInfo'][] = $productInfo;
        }
        return $mailInfos;
    }
}
