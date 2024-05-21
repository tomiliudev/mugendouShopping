@php
if ($name === 'image1') { $model = 'model-1'; }
if ($name === 'image2') { $model = 'model-2'; }
if ($name === 'image3') { $model = 'model-3'; }
if ($name === 'image4') { $model = 'model-4'; }
@endphp

<div class="modal micromodal-slide" id="{{ $model }}" aria-hidden="true">
    <div class="modal__overlay z-50" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="{{ $model }}-title">
        <header class="modal__header">
            <h2 class="modal__title" id="{{ $model }}-title">
            画像を選択してください。
            </h2>
            <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal__content" id="{{ $model }}-content">
            @if ($images->isEmpty())
            画像がありません！
            @else
                <div class="flex flex-wrap">
                    @foreach ($images as $image)
                        <div class="w-1/2 md:w-1/4 p-2">
                            <div class="border rounded-md p-2">
                                <div class="text-xl">
                                    {{$image->title;}}
                                </div>
                                <img class="image" src="{{ asset("storage/product/$image->imageName") }}"
                                data-id="{{ $name }}_{{ $image->id }}"
                                data-image_name="{{ $image->imageName }}"
                                data-path={{ asset("storage/product/") }}

                                {{-- data-micromodal-closeをつけると該当の要素が閉じる、こちらの場合はimgタグをクリックすると閉じる --}}
                                data-micromodal-close>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
        <footer class="modal__footer">
            <button type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
        </footer>
        </div>
    </div>
</div>

<div class="flex justify-start items-center mb-4">
    <div class="mr-4">
        <a class="py-2 px-4 bg-gray-200" href="javascript:;" data-micromodal-trigger="{{ $model }}">画像を選択</a>
    </div>
    <div class="w-1/4">
        <img id="{{ $name }}_thumbnail" src="" />
    </div>
</div>
<input id="{{ $name }}_hidden" type="hidden" name="{{ $name }}" value="" />
