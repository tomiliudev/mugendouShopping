@php
    if (!isset($classStyle)) {
        $classStyle = '';
    }
@endphp
@if (empty($imageName))
    <img @if ($classStyle)
        class="{{$classStyle}}"
    @endif src="{{ asset('images/no_image.png') }}">
@else
    <img @if ($classStyle)
        class="{{$classStyle}}"
    @endif src="{{ asset("storage/$folder/$imageName") }}">
@endif
