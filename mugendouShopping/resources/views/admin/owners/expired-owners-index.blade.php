<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            期限切れオーナー一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">

                            <div class="mb-4">
                                <x-flash-message status="{{ session('status') }}" />
                            </div>

                            @if ($expiredOwnerList->isEmpty())
                            期限切れのオーナーがありません！
                            @else
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">名前</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メール</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">登録日</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">削除日</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expiredOwnerList as $owner)
                                    <tr>
                                        <td class="px-4 py-3">{{$owner->name;}}</td>
                                        <td class="px-4 py-3">{{$owner->email;}}</td>
                                        <td class="px-4 py-3">{{$owner->created_at;}}</td>
                                        <td class="px-4 py-3">{{$owner->deleted_at;}}</td>
                                        <td class="px-4 py-3">
                                            <form id="delete_{{ $owner->id }}" method="POST" action="{{ route('admin.expired-owners.destroy', ['owner' => $owner->id]) }}">
                                                @csrf
                                                <x-danger-button-not-submit data-id="{{ $owner->id }}" onclick="deleteOwner(this)">完全削除</x-danger-button-not-submit>
                                            </form>
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

<script>
    function deleteOwner (e) {
        "use strict";
        if (confirm("本当に削除してよろしいですか？")) {
            document.getElementById("delete_" + e.dataset.id).submit();
        }
    }
</script>
