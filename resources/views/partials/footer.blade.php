@php
    $onHome    = request()->routeIs('home');
    $onContact = request()->routeIs('contact');
    $home      = route('home');

    // Same in-page-anchor rule as the header: link to the section directly when
    // we're already on the page that holds it.
    $anchor = fn (string $route, string $fragment) =>
        request()->routeIs($route) ? $fragment : $home . $fragment;
@endphp

<!-- ============ FOOTER ============ -->
<footer class="site-footer">
  <div class="section-inner footer-inner">
    <div class="footer-brand">
      <a href="{{ $onHome ? '#top' : $home . '#top' }}" class="logo">Jono<span class="logo-dot">.</span></a>
      <p>jonoads.com · <a href="mailto:{{ config('mail.contact_address') }}">{{ config('mail.contact_address') }}</a></p>
    </div>

    <div class="footer-cols">
      <div class="footer-col">
        <h4>Site</h4>
        <a href="{{ request()->routeIs('roas-engine') ? '#top' : route('roas-engine') }}">ROAS Engine</a>
        <a href="{{ request()->routeIs('services') ? '#top' : route('services') }}">Services</a>
        <a href="{{ request()->routeIs('work') ? '#top' : route('work') }}">Work</a>
        <a href="{{ request()->routeIs('team') ? '#top' : route('team') }}">Team</a>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <a href="{{ $anchor('home', '#partners') }}">Partners</a>
        <a href="{{ $onContact ? '#locations' : route('contact') . '#locations' }}">Locations</a>
        <a href="{{ route('smb') }}">SMB program</a>
        <a href="{{ $onContact ? '#top' : route('contact') }}">Contact</a>
      </div>
      <div class="footer-col">
        <h4>More</h4>
        <a href="{{ $onContact ? '#newsletter' : route('contact') . '#newsletter' }}">Newsletter</a>
        <a href="{{ config('services.skool.url') }}" target="_blank" rel="noopener">Skool community</a>
        <a href="{{ $anchor('home', '#podcast') }}">Podcast</a>
        <a href="{{ $home }}#merch">Merch</a>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; {{ now()->year }} Jono Advertising. All rights reserved.</p>
  </div>
</footer>
