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
                                <div class="md:w-1/2 w-full">
                                    <!-- Slider main container -->
                                    <div class="swiper">

                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper">
                                            <!-- Slides -->
                                            @if ($product->imageOne)
                                                <div class="swiper-slide"><x-thumbnail :imageName="$product->imageOne->imageName" folder='product' /></div>
                                            @endif
                                            @if ($product->imageTwo)
                                                <div class="swiper-slide"><x-thumbnail :imageName="$product->imageTwo->imageName" folder='product' /></div>
                                            @endif
                                            @if ($product->imageThree)
                                                <div class="swiper-slide"><x-thumbnail :imageName="$product->imageThree->imageName" folder='product' /></div>
                                            @endif
                                            @if ($product->imageFour)
                                                <div class="swiper-slide"><x-thumbnail :imageName="$product->imageFour->imageName" folder='product' /></div>
                                            @endif
                                        </div>

                                        <!-- If we need navigation buttons -->
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>

                                        <!-- If we need pagination -->
                                        <div class="swiper-pagination"></div>

                                        <!-- If we need scrollbar -->
                                        <div class="swiper-scrollbar"></div>
                                    </div>
                                </div>

                                <div class="md:w-1/2 w-full md:pl-10 mt-6 md:mt-0">
                                    <h2 class="mb-4 text-sm title-font text-gray-500 tracking-widest">{{ $product->secondaryCategory->name }}</h2>
                                    <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->name }}</h1>

                                    <p class="mb-4 leading-relaxed">{{ $product->information }}</p>

                                    <div class="relative">
                                        <span class="mr-3">数量</span>
                                        <select name="quantity" class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                            @for ($i = 1; $i <= $quantity; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="pb-5 border-b-2 border-gray-100 mb-5"></div>

                                    <div class="flex items-center">
                                        <span class="title-font font-medium text-2xl text-gray-900">{{ number_format($product->price) }}<span class="text-sm text-gray-700">円（税込）</span></span>
                                        <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">カートに入れる</button>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-5 border-b-2 border-gray-100 mb-5"></div>

                            <div class="text-center">
                                <div class="mb-4">この商品を販売しているショップ</div>
                                <div class="mb-4">{{ $product->shop->name }}</div>
                                <div class="mb-4"><x-thumbnail :imageName='$product->shop->imageName' folder='shop' classStyle='mx-auto w-40 h-40 rounded-full object-cover' /></div>
                                <button type="button" class="ml-auto text-white bg-gray-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-600 rounded" data-micromodal-trigger="shop-modal">ショップの詳細を見る</button>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>

    <div class="modal micromodal-slide" id="shop-modal" aria-hidden="true">
        <div class="modal__overlay z-50" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="shop-modal-title">
            <header class="modal__header">
                <h2 class="modal__title" id="shop-modal-title">
                {{ $product->shop->name }}
                </h2>
                <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="shop-modal-content">
                <p>{{ $product->shop->information }}</p>
            </main>
            <footer class="modal__footer">
                <button type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
            </footer>
            </div>
        </div>
    </div>

    @vite(['resources/css/swiper.css', 'resources/js/swiper.js'])
</x-app-layout>
