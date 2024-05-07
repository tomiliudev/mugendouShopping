<?php

namespace App\Http\Controllers\admin;

use App\Models\Owner;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OwnersRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ownerList = Owner::paginate(6);
        return view('admin.owners.index', compact('ownerList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnersRequest $request)
    {
        $request->validate(['email' => 'required|string|email|max:255|unique:owners']);

        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.owners.index')->with([
            'message' => 'オーナー情報を登録しました。',
            'status' => 'info'
        ]);
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
        $owner = Owner::findOrFail($id);
        return view('admin.owners.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OwnersRequest $request, string $id)
    {
        $request->validate(['email' => ['required', 'string', 'email', 'max:255', Rule::unique(Owner::class)->ignore($id)]]);

        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();

        return redirect()->route('admin.owners.index')->with([
            'message' => 'オーナー情報を更新しました。',
            'status' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Owner::findOrFail($id)->delete();
        return redirect()->route('admin.owners.index')->with([
            'message' => 'オーナーを削除しました。',
            'status' => 'warning'
        ]);
    }

    public function expiredOwnerIndex()
    {
        $expiredOwnerList = Owner::onlyTrashed()->get();
        return view('admin.owners.expired-owners-index', compact('expiredOwnerList'));
    }

    public function expiredOwnerDestroy(string $id)
    {
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.expired-owners.index')->with([
            'message' => '完全に削除しました。',
            'status' => 'warning'
        ]);
    }
}
