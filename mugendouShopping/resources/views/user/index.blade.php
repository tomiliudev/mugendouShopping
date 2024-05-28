<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ホーム
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:px-6 py-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 py-24 mx-auto">

                            <div class="pb-4"><x-flash-message status="{{ session('status') }}" /></div>

                            @if ($products->isEmpty())
                            商品がありません！
                            @else
                                <div class="flex flex-wrap">
                                    @foreach ($products as $product)
                                        <div class="w-1/2 md:w-1/4 p-2">
                                            <a href="{{route('owner.products.edit', ['product' => $product->id])}}">
                                                <div class="border rounded-md p-2">
                                                    <x-thumbnail :imageName="is_null($product->imageOne) ? '' : $product->imageOne->imageName" folder='product' />
                                                    <div class="mt-4">
                                                    <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{$product->secondaryCategory->name}}</h3>
                                                    <h2 class="text-gray-900 title-font text-lg font-medium">{{$product->name}}</h2>
                                                    <p class="mt-1">{{ number_format($product->price) }}<span class="text-sm text-grey-700">円（税込）</span></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
