<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            画像情報の更新
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">

                            <form id="delete" method="POST" action="{{ route('owner.images.destroy', ['image' => $image->id]) }}">
                                @csrf
                                @method('delete')
                                <div class="flex justify-end mb-4">
                                    <x-danger-button-not-submit onclick="deleteImage(this)">削除</x-danger-button-not-submit>
                                </div>
                            </form>

                            <form method="post" action="{{ route('owner.images.update', ['image' => $image->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="relative mb-4">
                                    <label for="title" class="leading-7 text-sm text-gray-600">タイトル</label>
                                    <input type="text" id="title" name="title" value="{{ $image->title }}" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                                    <div class="w-64 pb-2"><x-thumbnail :imageName='$image->imageName' folder='product' /></div>
                                    <input type="file" id="image" name="uploadImage" accept="image/jpeg,image/jpg,image/png" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->first('uploadImage')" class="mt-2" />
                                </div>

                                <div class="flex justify-between">
                                    <x-secondary-button onclick="location.href='{{ route('owner.images.index') }}'">戻る</x-secondary-button>
                                    <x-primary-button>更新する</x-primary-button>
                                </div>
                            </form>

                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function deleteImage (e) {
        "use strict";
        if (confirm("本当に削除してよろしいですか？")) {
            document.getElementById("delete").submit();
        }
    }
</script>
