@extends('layouts.app')

@section('title', "Contact — Jono Advertising")
@section('description', 'Get in touch with Jono Advertising. Email info@jonoadvertising.com, or find our media buying, creative, CRM, and accounts teams across Miami, New York, Dallas, LA, and the Bay Area.')

@section('content')
<!-- ============ CONTACT HERO ============ -->
<section class="engine-hero" id="top">
  <div class="section-inner engine-hero-inner">
    <p class="eyebrow-free-label reveal">Get in touch</p>
    <h1 class="reveal">Let's Do Great Things Together.</h1>
    <div class="hero-actions reveal">
      <a href="#enquiry" class="btn btn-primary">Send an enquiry</a>
      <a href="mailto:{{ \App\Models\SiteSetting::get('contact_email') }}" class="btn btn-ghost">Or email us directly</a>
    </div>

    <x-section.hero-stats group="contact_hero" class="reveal" />
  </div>
</section>

<!-- ============ QUICK LINKS ============ -->
<section class="contact-quick">
  <div class="section-inner">
    <div class="contact-quick-grid">
      <a href="mailto:info@jonoadvertising.com" class="contact-quick-card reveal">
        <h3>Email us</h3>
        <p>info@jonoadvertising.com</p>
      </a>
      <a href="https://www.skool.com" target="_blank" rel="noopener" class="contact-quick-card reveal">
        <h3>Skool community</h3>
        <p>Join the discussion</p>
      </a>
      <a href="{{ route('home') }}#podcast" class="contact-quick-card reveal">
        <h3>Podcast</h3>
        <p>Media buying, unfiltered</p>
      </a>
      <a href="{{ route('home') }}#merch" class="contact-quick-card reveal">
        <h3>Merch</h3>
        <p>Rep the Engine</p>
      </a>
    </div>
  </div>
</section>

<!-- ============ ENQUIRY FORM ============ -->
<section class="enquiry" id="enquiry">
  <div class="section-inner enquiry-inner">
    <div class="enquiry-intro">
      <p class="eyebrow-free-label reveal">Send an enquiry</p>
      <h2 class="reveal">Tell Us What You're Running.</h2>
      <p class="reveal">The more you tell us about the account, the more specific we can be about what we'd change first.</p>
    </div>
    <div class="reveal">
      <x-form.contact />
    </div>
  </div>
</section>

<!-- ============ LOCATIONS ============ -->
<section class="locations" id="locations">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Small team. Big impact.</p>
    <h2 class="reveal">Cross Cultures And Time Zones. We Understand People.</h2>

    <x-section.locations />
  </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="newsletter" id="newsletter">
  <div class="section-inner newsletter-inner reveal">
    <div>
      <h2>Media buying notes, monthly.</h2>
      <p>What's working on Meta, Google, and CTV right now — no fluff, straight from the people running the accounts.</p>
    </div>
    <x-form.newsletter />
  </div>
</section>
@endsection
