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

                            <x-flash-message status="{{session('status')}}"/>

                            <form id="delete" method="POST" action="{{ route('owner.products.destroy', ['product' => $product->id]) }}">
                                @csrf
                                @method('delete')
                                <div class="flex justify-end mb-4">
                                    <x-danger-button-not-submit onclick="deleteProduct(this)">削除する</x-danger-button-not-submit>
                                </div>
                            </form>

                            <form method="post" action="{{ route('owner.products.update', ['product' => $product->id]) }}">
                                @csrf
                                @method('PUT')

                                <div class="relative mb-4">
                                    <label for="name" class="leading-7 text-sm text-gray-600">商品名 ※必須</label>
                                    <input type="text" id="name" name="name" value="{{ $product->name }}" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ※必須</label>
                                    <textarea id="information" name="information" rows="10" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $product->information }}</textarea>
                                    <x-input-error :messages="$errors->get('information')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="price" class="leading-7 text-sm text-gray-600">価格 ※必須</label>
                                    <input type="number" id="price" name="price" value="{{ $product->price }}" min="0" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="sortOrder" class="leading-7 text-sm text-gray-600">表示順</label>
                                    <input type="number" id="sortOrder" name="sortOrder" value="{{ $product->sortOrder }}" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('sortOrder')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label class="leading-7 text-sm text-gray-600">現在の在庫数</label>
                                    <input type="hidden" id="current_quantity" name="current_quantity" value="{{ $quantity }}">
                                    <div class="w-full bg-gray-100 rounded text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $quantity }}</div>
                                </div>

                                <div class="relative mb-4">
                                    <div class="flex justify-start">
                                        <div class="pr-4">
                                            <input type="radio" id="quantityType1" name="quantityType" value="{{ \App\Constants\Config::PRODUCT_ADD }}">
                                            <label for="quantityType1" class="leading-7 text-sm text-gray-600">追加</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="quantityType2" name="quantityType" value="{{ \App\Constants\Config::PRODUCT_REDUCE }}">
                                        <label for="quantityType2" class="leading-7 text-sm text-gray-600">削減</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="relative mb-4">
                                    <input type="number" id="quantity" name="quantity" value="0" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <span>0〜99の範囲で入力してください。</span>
                                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="shopId" class="leading-7 text-sm text-gray-600">販売する店舗</label>
                                    <select id="shopId" name="shopId" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        @foreach ($shops as $shop)
                                            <option value="{{ $shop->id }}" @if ($product->shopId === $shop->id)
                                                selected
                                            @endif>
                                                {{ $shop->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->first('shopId')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="secondaryId" class="leading-7 text-sm text-gray-600">カテゴリ</label>
                                    <select id="secondaryId" name="secondaryId" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                        @foreach ($categories as $category)
                                            <optgroup label="{{ $category->name }}">
                                            @foreach ($category->secondaryCategories as $secondary)
                                                <option value="{{ $secondary->id }}" @if ($product->secondaryCategory->id === $secondary->id)
                                                    selected
                                                @endif>
                                                    {{ $secondary->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->first('category')" class="mt-2" />
                                </div>

                                <x-select-image name="image1" :images="$images" :currentId="$product->image1 ?? ''" :currentImageName="$product->imageOne->imageName ?? ''"/>
                                <x-select-image name="image2" :images="$images" :currentId="$product->image2 ?? ''" :currentImageName="$product->imageTwo->imageName ?? ''"/>
                                <x-select-image name="image3" :images="$images" :currentId="$product->image3 ?? ''" :currentImageName="$product->imageThree->imageName ?? ''"/>
                                <x-select-image name="image4" :images="$images" :currentId="$product->image4 ?? ''" :currentImageName="$product->imageFour->imageName ?? ''"/>

                                <div class="relative mb-4">
                                    <div class="flex justify-start">
                                        <div class="pr-4">
                                            <input type="radio" id="isSelling1" name="isSelling" value="1" @if ($product->isSelling)
                                                checked
                                            @endif>
                                            <label for="isSelling1" class="leading-7 text-sm text-gray-600">販売中</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="isSelling0" name="isSelling" value="0" @if (!$product->isSelling)
                                                checked
                                            @endif>
                                        <label for="isSelling0" class="leading-7 text-sm text-gray-600">停止中</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between">
                                    <x-secondary-button onclick="location.href='{{ route('owner.products.index') }}'">戻る</x-secondary-button>
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

    function deleteProduct (e) {
        if (confirm("本当に削除してよろしいですか？")) {
            document.getElementById("delete").submit();
        }
    }
</script>
