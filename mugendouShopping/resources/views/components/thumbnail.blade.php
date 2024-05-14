@if (empty($imageName))
    <img src="{{ asset('images/no_image.png') }}">
@else
    <img src="{{ asset("storage/$folder/$imageName") }}">
@endif
