<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Services\ImageService;
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
        $images = Image::where('ownerId', Auth::id())->orderBy('updated_at', 'desc')->paginate(8);
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
        $images = $request->file('files');
        if (!is_null($images)) {
            $folder = 'product';
            foreach ($images as $image) {
                $uniqFileName = ImageService::upload($image['image'], $folder);
                Image::create([
                    'ownerId' => Auth::id(),
                    'imageName' => $uniqFileName,
                ]);
            }
        }
        return redirect()->route('owner.images.index')->with(['message' => '画像を登録しました。', 'status' => 'info']);
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
