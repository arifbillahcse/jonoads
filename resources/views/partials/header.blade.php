@php
    // On the page a nav item points at, the link becomes an in-page anchor
    // instead of a reload — this reproduces the behaviour the static pages
    // hand-maintained in six separate copies of this markup.
    $nav = [
        ['route' => 'roas-engine', 'label' => 'ROAS Engine'],
        ['route' => 'services',    'label' => 'Services'],
        ['route' => 'work',        'label' => 'Work'],
        ['route' => 'team',        'label' => 'Team'],
    ];
    $onHome    = request()->routeIs('home');
    $onContact = request()->routeIs('contact');
@endphp

<!-- ============ NAV ============ -->
<header class="site-header" id="siteHeader">
  <div class="header-inner">
    <a href="{{ $onHome ? '#top' : route('home') . '#top' }}" class="logo">Jono<span class="logo-dot">.</span></a>

    <nav class="main-nav" id="mainNav">
      @foreach ($nav as $item)
        <a href="{{ request()->routeIs($item['route']) ? '#top' : route($item['route']) }}">{{ $item['label'] }}</a>
      @endforeach
      <a href="{{ $onHome ? '#partners' : route('home') . '#partners' }}">Partners</a>
      <a href="{{ $onContact ? '#top' : route('contact') }}" class="nav-cta">Schedule a call</a>
    </nav>

    <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>
