<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            カート情報
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($products->isEmpty())
                        カートが空です。
                    @else
                        @foreach ($products as $product)
                            <div class="md:flex md:items-center mb-2">
                                <div class="md:w-3/12 mr-2"><x-thumbnail :imageName="$product->imageOne->imageName" folder='product' /></div>
                                <div class="md:w-4/12">{{ $product->name }}</div>
                                <div class="md:w-3/12">
                                    <div class="flex justify-around">
                                        <div>{{ $product->pivot->quantity }}個</div>
                                        <div>{{ number_format($product->pivot->quantity * $product->price) }}<span class="text-sm text-gray-700">円（税込）</span></div>
                                    </div>
                                </div>
                                <div class="md:w-2/12"><x-danger-button class="ms-3">削除する</x-danger-button></div>
                            </div>
                        @endforeach
                        {{-- {{ number_format($totalPrice) }} --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
