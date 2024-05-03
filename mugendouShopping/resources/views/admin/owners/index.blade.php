<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">

                            <x-flash-message status='info' />

                            <div class="flex justify-end mb-4">
                                <x-primary-button onclick="location.href='{{ route('admin.owners.create') }}'">新規登録する</x-primary-button>
                            </div>

                            @if ($ownerList->isEmpty())
                            表示可能なオーナーがありません！
                            @else
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">名前</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メール</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">登録日</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ownerList as $owner)
                                    <tr>
                                        <td class="px-4 py-3">{{$owner->name;}}</td>
                                        <td class="px-4 py-3">{{$owner->email;}}</td>
                                        <td class="px-4 py-3">{{$owner->created_at;}}</td>
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
