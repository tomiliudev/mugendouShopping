<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ショップ一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:px-6 py-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 py-24 mx-auto">

                            <div class="pb-4"><x-flash-message status="{{ session('status') }}" /></div>

                            @if ($shopList->isEmpty())
                            ショップがありません！
                            @else
                                @foreach ($shopList as $shop)
                                <div class="border rounded w-1/2 p-2">
                                    <a href="{{route('owner.shop.edit', ['shop' => $shop->id])}}">
                                        <div class="pt-2 pb-2 text-white">
                                            @if ($shop->isEnable)
                                                <span class="p-2 border rounded bg-green-500">販売中</span>
                                            @else
                                                <span class="p-2 border rounded bg-red-500">停止中</span>
                                            @endif
                                        </div>
                                        <div class="pb-2 text-xl">
                                            {{$shop->name;}}
                                        </div>
                                        <x-thumbnail :imageName='$shop->imageName' folder='shop' />
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
