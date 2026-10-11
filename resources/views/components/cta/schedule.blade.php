@props(['label' => 'Schedule a call'])
{{--
    Every "Schedule a call" button on the site renders through here, so the
    destination is decided in one place: the booking link from Settings when
    one is set, otherwise the contact form, which is what these buttons did
    before a booking link existed.

    Tried opening the booking page as an on-site popup (an iframe in a
    dialog, like the case study "Watch the Video" buttons), but the
    client's booking provider refuses to render inside an iframe on
    another site (a security header it sets, not something fixable from
    here) — the popup only ever showed blank. Back to a plain new tab.
--}}
@php($calendly = \App\Models\SiteSetting::get('calendly_url'))

@if (filled($calendly))
<a href="{{ $calendly }}" target="_blank" rel="noopener" {{ $attributes }}>{{ $label }}</a>
@else
<a href="{{ request()->routeIs('contact') ? '#top' : route('contact') }}" {{ $attributes }}>{{ $label }}</a>
@endif
