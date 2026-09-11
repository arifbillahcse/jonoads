@php
    $title = trim($__env->yieldContent('title', config('app.name')));
    $description = trim($__env->yieldContent('description'));
    // Canonical without query strings, so filtered or campaign-tagged URLs
    // don't register as separate pages.
    $canonical = url()->current();
    // A card uploaded under Settings wins; otherwise the packaged default.
    $custom = \App\Models\SiteSetting::get('share_image');
    $shareImage = filled($custom)
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($custom)
        : asset('share-card.png');
@endphp

<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $shareImage }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $shareImage }}">

<meta name="theme-color" content="#0a0a0a">

<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

{{-- Organisation schema: lets search engines attach the name, contact address
     and offices to the brand rather than inferring them. --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => config('app.name'),
    'url' => route('home'),
    'logo' => asset('favicon.svg'),
    'email' => \App\Models\SiteSetting::get('contact_email'),
    'contactPoint' => [
        '@type' => 'ContactPoint',
        'contactType' => 'sales',
        'email' => \App\Models\SiteSetting::get('contact_email'),
    ],
    'address' => \App\Support\SiteContent::locations()->map(fn ($location) => [
        '@type' => 'PostalAddress',
        'addressLocality' => $location->city,
    ])->values()->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
