@php
    // On the page a nav item points at, the link becomes an in-page anchor
    // instead of a reload — this reproduces the behaviour the static pages
    // hand-maintained in six separate copies of this markup.
    $nav = [
        ['route' => 'roas-engine', 'label' => 'ROAS Engine'],
        ['route' => 'services',    'label' => 'Services'],
        ['route' => 'case-studies', 'label' => 'Case Studies'],
        ['route' => 'team',        'label' => 'Team'],
    ];
    $onHome = request()->routeIs('home');
@endphp

<!-- ============ NAV ============ -->
<header class="site-header" id="siteHeader">
  <div class="header-inner">
    <x-brand.logo />

    <nav class="main-nav" id="mainNav">
      @foreach ($nav as $item)
        <a href="{{ request()->routeIs($item['route']) ? '#top' : route($item['route']) }}">{{ $item['label'] }}</a>
      @endforeach
      <a href="{{ $onHome ? '#partners' : route('home') . '#partners' }}">Partners</a>
      <x-cta.schedule class="nav-cta" />
    </nav>

    <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>
