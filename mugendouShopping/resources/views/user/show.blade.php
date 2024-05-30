<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品の詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <section class="text-gray-600 body-font overflow-hidden">
                        <div class="container px-5 py-4 mx-auto">
                            <div class="flex flex-wrap">

                                <div class="md:w-1/2">
                                    <x-thumbnail :imageName="is_null($product->imageOne) ? '' : $product->imageOne->imageName" folder='product' />
                                </div>

                                <div class="md:w-1/2 w-full md:pl-10 mt-6 md:mt-0">
                                    <h2 class="mb-4 text-sm title-font text-gray-500 tracking-widest">{{ $product->secondaryCategory->name }}</h2>
                                    <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->name }}</h1>

                                    <p class="mb-4 leading-relaxed">{{ $product->information }}</p>

                                    <div class="relative">
                                        <span class="mr-3">数量</span>
                                        <select class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </div>

                                    <div class="flex pb-5 border-b-2 border-gray-100 mb-5"></div>

                                    <div class="flex items-center">
                                        <span class="title-font font-medium text-2xl text-gray-900">{{ number_format($product->price) }}<span class="text-sm text-gray-700">円（税込）</span></span>
                                        <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">カートに入れる</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
