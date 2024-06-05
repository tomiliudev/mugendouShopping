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

                    <div class="pb-4"><x-flash-message status="{{ session('status') }}" /></div>

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
                                <div class="md:w-2/12">
                                    <form id="delete_{{ $product->id }}" action="{{ route('cart.delete', ['product' => $product->id]) }}" method="post">
                                        @csrf
                                        <button type="button" data-id="{{$product->id}}" onclick="deleteItem(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <div class="pb-5 border-b-2 border-gray-100 mb-5"></div>

                        <div class="flex">
                            <div class="mr-4">合計金額</div>
                            <div>{{ number_format($totalPrice) }}<span class="text-sm text-gray-700">円（税込）</span></div>
                        </div>

                        <form action="{{route("cart.checkout")}}" method="get">
                            <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">購入する</button>
                        </form>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    "use strict";
    function deleteItem(e) {
        if (confirm('本当に削除してよろしいですか？')) {
            document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
</script>
