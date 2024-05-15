<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            画像一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:px-6 py-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 py-24 mx-auto">

                            <div class="pb-4"><x-flash-message status="{{ session('status') }}" /></div>

                            <div class="flex justify-end mb-4">
                                <x-primary-button onclick="location.href='{{ route('owner.images.create') }}'">新規登録する</x-primary-button>
                            </div>

                            @if ($images->isEmpty())
                            画像がありません！
                            @else
                                <div class="flex flex-wrap">
                                    @foreach ($images as $image)
                                        <div class="w-1/4 p-4">
                                            <a href="{{route('owner.images.edit', ['image' => $image->id])}}">
                                                <div class="border rounded-md p-4">
                                                    <div class="text-xl">
                                                        {{$image->title;}}
                                                    </div>
                                                    <x-thumbnail :imageName='$image->imageName' folder='product' />
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                {{ $images->links() }}
                            @endif
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
