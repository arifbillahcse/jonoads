@props(['label' => 'Schedule a call'])
{{--
    Every "Schedule a call" button on the site renders through here, so the
    destination is decided in one place: the booking link from Settings when
    one is set, otherwise the contact form, which is what these buttons did
    before a booking link existed.

    A first attempt at an on-site popup hand-rolled an iframe in a dialog
    (like the case study "Watch the Video" buttons) — the booking page
    refused to render inside it via X-Frame-Options, so it only ever
    showed blank. This version instead uses Calendly's own popup widget
    (initCalendlyPopup() in app.js, triggered by the js-calendly-trigger
    class below), which is Calendly's own supported embed and isn't
    subject to that block. The real href/target stay in place as a
    fallback for whenever JS or the Calendly script hasn't loaded.
--}}
@php($calendly = \App\Models\SiteSetting::get('calendly_url'))

@if (filled($calendly))
<a
    href="{{ $calendly }}"
    target="_blank"
    rel="noopener"
    data-calendly-url="{{ $calendly }}"
    {{ $attributes->merge(['class' => 'js-calendly-trigger']) }}
>{{ $label }}</a>
@else
<a href="{{ request()->routeIs('contact') ? '#top' : route('contact') }}" {{ $attributes }}>{{ $label }}</a>
@endif
