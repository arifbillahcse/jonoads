@props(['case'])
{{--
    Only appears once a YouTube link is on the case study, so a card without
    one simply doesn't offer a video. The button carries the id rather than a
    URL — the player is built from it, so nothing but YouTube can be embedded.
--}}
@php($videoId = $case->youtubeId())

@if ($videoId)
<button
    type="button"
    {{ $attributes->merge(['class' => 'btn btn-ghost case-video-btn']) }}
    data-video-id="{{ $videoId }}"
    data-video-title="{{ $case->client }}"
>
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="case-video-icon">
        <path d="M9.5 8.2v7.6l6.2-3.8z" fill="currentColor"/>
        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
    </svg>
    Watch the Video
</button>
@endif
