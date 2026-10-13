<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', config('app.name'))</title>
<meta name="description" content="@yield('description')">
@include('partials.meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
{{--
    Calendly's own popup widget, loaded once site-wide since "Schedule a
    call" appears on every page. This is Calendly's own supported embed
    mechanism — unlike the hand-rolled iframe-in-a-dialog tried earlier
    (which the booking page refused to render inside, via
    X-Frame-Options), Calendly's widget.js opens the page in an overlay
    Calendly itself controls, so it isn't subject to that same block.

    The popup still has to load Calendly's own booking page as a fresh
    connection at click time, which is the bulk of the delay before it
    appears — preconnecting to both of Calendly's domains here lets the
    browser do that connection setup (DNS, TLS) while the rest of the
    page is still loading, instead of only starting it on click.
--}}
<link rel="preconnect" href="https://assets.calendly.com">
<link rel="preconnect" href="https://calendly.com">
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

{{-- First stop for a keyboard or screen-reader user: skip the nav. --}}
<a href="#main" class="skip-link">Skip to content</a>

@include('partials.header')

<main id="main" tabindex="-1">

@yield('content')
</main>

@include('partials.footer')

<button type="button" class="back-to-top" id="backToTop" aria-label="Back to top">
  <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
</button>

</body>
</html>
