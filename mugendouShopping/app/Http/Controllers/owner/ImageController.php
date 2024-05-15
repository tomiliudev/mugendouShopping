<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller implements HasMiddleware
{
    /**
     * コントローラへ指定するミドルウェアを取得
     */
    public static function middleware(): array
    {
        return [
            'auth:owner',
            function (Request $request, Closure $next) {
                $id = $request->route()->parameter('image');
                if (!is_null($id)) {
                    $id = (int)$id;
                    if (Image::findOrFail($id)->owner->id !== Auth::id()) {
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
        $images = Image::where('ownerId', Auth::id())->orderBy('updated_at', 'desc')->paginate(20);
        return view('owner.image.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.image.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadImageRequest $request)
    {
        dd("画像登録します！");
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
