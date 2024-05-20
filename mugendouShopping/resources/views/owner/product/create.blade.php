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
                                    <label for="category" class="leading-7 text-sm text-gray-600">カテゴリ</label>
                                    <select id="category" name="category">
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
