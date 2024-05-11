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

                            <x-flash-message status="{{ session('status') }}" />

                            @if ($shopList->isEmpty())
                            ショップがありません！
                            @else
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">店名</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">画像</th>
                                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shopList as $shop)
                                    <tr>
                                        <td class="md:px-4 py-3">{{$shop->name;}}</td>
                                        <td class="md:px-4 py-3">{{$shop->imageName;}}</td>
                                        <td class="md:px-4 py-3">
                                            <x-secondary-button onclick="location.href='{{ route('owner.shop.edit', ['shop' => $shop->id]) }}'">編集</x-secondary-button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
