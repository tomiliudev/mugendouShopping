<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            店舗情報の編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <form method="post" action="{{ route('owner.shop.update', ['shop' => $shop->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="relative mb-4">
                                    <label for="name" class="leading-7 text-sm text-gray-600">店名</label>
                                    <input type="text" id="name" name="name" value="{{ $shop->name }}" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="information" class="leading-7 text-sm text-gray-600">店舗情報</label>
                                    <textarea id="information" name="information" rows="10" required class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $shop->information }}</textarea>
                                    <x-input-error :messages="$errors->get('information')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                                    <div class="w-64 pb-2"><x-thumbnail :imageName='$shop->imageName' folder='shop' /></div>
                                    <input type="file" id="image" name="uploadImage" accept="image/jpeg,image/jpg,image/png" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->first('uploadImage')" class="mt-2" />
                                </div>

                                <div class="relative mb-4">
                                    <div class="flex justify-start">
                                        <div class="pr-4">
                                            <input type="radio" id="isEnable1" name="isEnable" value="1" @if ($shop->isEnable) { checked } @endif>
                                            <label for="isEnable1" class="leading-7 text-sm text-gray-600">販売中</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="isEnable0" name="isEnable" value="0" @if (!$shop->isEnable) { checked } @endif>
                                        <label for="isEnable0" class="leading-7 text-sm text-gray-600">停止中</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between">
                                    <x-secondary-button onclick="location.href='{{ route('owner.shop.index') }}'">戻る</x-secondary-button>
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
