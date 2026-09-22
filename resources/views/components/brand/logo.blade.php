{{--
    The wordmark, or an uploaded logo once one is set under Settings. Header
    and footer both render this, so the brand only has to be changed once.
--}}
@php
    $logo = \App\Models\SiteSetting::get('logo_image');
    $onHome = request()->routeIs('home');
    $href = $onHome ? '#top' : route('home') . '#top';
@endphp

<a href="{{ $href }}" class="logo" {{ $attributes }}>
    @if (filled($logo))
        <img class="logo-image" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($logo) }}" alt="Jono Advertising">
    @else
        Jono
    @endif
</a>
