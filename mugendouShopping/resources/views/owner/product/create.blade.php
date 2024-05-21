<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品の新規登録
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <form method="post" action="{{ route('owner.products.store') }}">
                                @csrf

                                <div class="relative mb-4">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                                    <textarea id="information" name="information" rows="10" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('information') }}</textarea>
                                    <x-input-error :messages="$errors->get('information')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                                    <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="sortOrder" class="leading-7 text-sm text-gray-600">表示順</label>
                                    <input type="number" id="sortOrder" name="sortOrder" value="{{ old('sortOrder') }}" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('sortOrder')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="quantity" class="leading-7 text-sm text-gray-600">初期在庫数 ※必須</label>
                                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="shop" class="leading-7 text-sm text-gray-600">販売する店舗</label>
                                    <select id="shop" name="shop" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        @foreach ($shops as $shop)
                                            <option value="{{$shop->id}}">
                                                {{$shop->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="relative mb-4">
                                    <label for="category" class="leading-7 text-sm text-gray-600">カテゴリ</label>
                                    <select id="category" name="category" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        @foreach ($categories as $category)
                                            <optgroup label="{{ $category->name }}">
                                            @foreach ($category->secondaryCategories as $secondary)
                                                <option value="{{$secondary->id}}">
                                                    {{$secondary->name}}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->first('category')" class="mt-2" />
                                </div>

                                <x-select-image name="image1" :images="$images" />
                                <x-select-image name="image2" :images="$images" />
                                <x-select-image name="image3" :images="$images" />
                                <x-select-image name="image4" :images="$images" />

                                <div class="relative mb-4">
                                    <div class="flex justify-start">
                                        <div class="pr-4">
                                            <input type="radio" id="isEnable1" name="isEnable" value="1" {{ is_null(old('isEnable')) || old('isEnable') == 1 ? 'checked' : '' }}>
                                            <label for="isEnable1" class="leading-7 text-sm text-gray-600">販売中</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="isEnable0" name="isEnable" value="0" {{ !is_null(old('isEnable')) && old('isEnable') == 0 ? 'checked' : '' }}>
                                        <label for="isEnable0" class="leading-7 text-sm text-gray-600">停止中</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between">
                                    <x-secondary-button onclick="location.href='{{ route('owner.products.index') }}'">戻る</x-secondary-button>
                                    <x-primary-button>登録する</x-primary-button>
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
    "use strict";
    const images = document.querySelectorAll('.image');

    for (var image of images) {
        image.addEventListener('click', function (e) {
            const imageName = e.target.dataset.id.substr(0, 6);
            const imageId = e.target.dataset.id.replace(imageName + '_', '');
            const fileName = e.target.dataset.image_name;
            const imagePath = e.target.dataset.path;
            document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + fileName;
            document.getElementById(imageName + '_hidden').value = imageId;
        });
    }
</script>
