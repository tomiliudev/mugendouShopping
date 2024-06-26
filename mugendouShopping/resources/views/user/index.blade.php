<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ホーム
            </h2>
            <div>
                <form action="{{ route('item.index') }}" method="GET">
                    @csrf

                    {{-- キーワード --}}
                    <span class="text-sm">※スペース区切りで複数指定可能</span><br>
                    <input placeholder="キーワードを入力" name="keyword" value="{{ \Request::get('keyword') }}">
                    <button class="ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">検索する</button>

                    {{-- カテゴリ --}}
                    <select name="category" id="category">
                        <option value="0">すべて</option>
                        @foreach ($categoryList as $category)
                            <optgroup label="{{$category->name}}">
                            @foreach ($category->secondaryCategories as $secCategory)
                                <option value="{{$secCategory->id}}" @if (\Request::get('category') == $secCategory->id)
                                    selected
                                @endif>{{$secCategory->name}}</option>
                            @endforeach
                            </optgroup>
                        @endforeach
                    </select>

                    {{-- 表示順 --}}
                    <select name="sort" id="sort">
                        @foreach ($sortTypeList as $sortType => $sortName)
                            <option value="{{$sortType}}" @if (\Request::get('sort') == $sortType)
                                selected
                            @endif>{{$sortName}}</option>
                        @endforeach
                    </select>

                    {{-- 表示件数 --}}
                    <select name="pagination" id="pagination">
                        @foreach ($paginationList as $pagination => $paginationName)
                            <option value="{{$pagination}}" @if (\Request::get('pagination') == $pagination)
                                selected
                            @endif>{{$paginationName}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:px-6 py-6 text-gray-900">

                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 py-4 mx-auto">

                            <div class="pb-4"><x-flash-message status="{{ session('status') }}" /></div>

                            @if ($products->isEmpty())
                            商品がありません！
                            @else
                                <div class="flex flex-wrap">
                                    @foreach ($products as $product)
                                        <div class="w-1/2 md:w-1/4 p-2">
                                            <a href="{{route('item.show', ['product' => $product->id])}}">
                                                <div class="border rounded-md p-2">
                                                    <x-thumbnail :imageName="is_null($product->imageOne) ? '' : $product->imageOne->imageName" folder='product' />
                                                    <div class="mt-4">
                                                    <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{$product->secondaryCategory->name}}</h3>
                                                    <h2 class="text-gray-900 title-font text-lg font-medium">{{$product->name}}</h2>
                                                    <p class="mt-1">{{ number_format($product->price) }}<span class="text-sm text-gray-700">円（税込）</span></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                {{ $products->appends([
                                    'keyword' => \Request::get('keyword'),
                                    'category' => \Request::get('category'),
                                    'sort' => \Request::get('sort'),
                                    'pagination' => \Request::get('pagination'),
                                    ])->links()
                                }}
                            @endif
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

    var category = document.getElementById('category')
    category.addEventListener('change', function() {
        this.form.submit()
    })

    var sort = document.getElementById('sort')
    sort.addEventListener('change', function() {
        this.form.submit()
    })

    var pagination = document.getElementById('pagination')
    pagination.addEventListener('change', function() {
        this.form.submit()
    })
</script>
