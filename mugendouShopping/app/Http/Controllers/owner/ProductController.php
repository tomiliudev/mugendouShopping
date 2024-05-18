<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Product;
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
        $products = Owner::findOrFail(Auth::id())->shop->products;
        return view('owner.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
