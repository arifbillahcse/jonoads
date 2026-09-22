@props(['label' => 'Schedule a call'])
{{--
    Every "Schedule a call" button on the site renders through here, so the
    destination is decided in one place: the Calendly link from Settings when
    one is set, otherwise the contact form, which is what these buttons did
    before a booking link existed.
--}}
@php($calendly = \App\Models\SiteSetting::get('calendly_url'))

@if (filled($calendly))
<a href="{{ $calendly }}" target="_blank" rel="noopener" {{ $attributes }}>{{ $label }}</a>
@else
<a href="{{ request()->routeIs('contact') ? '#top' : route('contact') }}" {{ $attributes }}>{{ $label }}</a>
@endif
