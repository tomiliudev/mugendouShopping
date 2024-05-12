<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー編集
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
                                    <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                                    <input type="file" id="image" name="image" accept="image/jpeg,image/jpg,image/png" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    <x-input-error :messages="$errors->first('image')" class="mt-2" />
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
