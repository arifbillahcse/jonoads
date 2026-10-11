@props(['label' => 'Schedule a call'])
{{--
    Every "Schedule a call" button on the site renders through here, so the
    destination is decided in one place: the booking link from Settings when
    one is set, otherwise the contact form, which is what these buttons did
    before a booking link existed. With a link set, it opens as an on-site
    popup (the same dialog pattern the case study "Watch the Video" buttons
    use) rather than a new tab — the href is kept as a real link underneath
    so it still works with JS off, a middle-click, or a long-press.
--}}
@php($calendly = \App\Models\SiteSetting::get('calendly_url'))

@if (filled($calendly))
<a href="{{ $calendly }}" target="_blank" rel="noopener" data-booking-url="{{ $calendly }}" {{ $attributes->merge(['class' => 'js-booking-trigger']) }}>{{ $label }}</a>
@else
<a href="{{ request()->routeIs('contact') ? '#top' : route('contact') }}" {{ $attributes }}>{{ $label }}</a>
@endif
