@extends('layouts.app')

@section('title', "SMB Program — Jono Advertising")
@section('description', 'A dedicated paid media program for local and regional businesses — HVAC, electrical, construction, lawn care, interior design, med spas, pest control, and private schools.')

@section('content')

<!-- ============ SMB HERO ============ -->
<section class="engine-hero" id="top">
  <div class="section-inner engine-hero-inner">
    <p class="eyebrow-free-label reveal">SMB program</p>
    <h1 class="reveal">Enterprise media buying, sized for your market.</h1>
    <p class="engine-hero-sub reveal">
      The same buyers who run nine-figure budgets for billion-dollar brands, on a
      program built for a local and regional budget. One market, one team, and
      the same daily management the enterprise accounts get.
    </p>
    <div class="hero-actions reveal">
      <a href="{{ route('contact') }}" class="btn btn-primary">Schedule a call</a>
      <a href="#industries" class="btn btn-ghost">See who this is for</a>
    </div>
  </div>
</section>

<!-- ============ INDUSTRIES ============ -->
<section class="partners" id="industries">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Who this is for</p>
    <h2 class="reveal">Built around how local demand actually works.</h2>

    <div class="partner-grid">
      <div class="partner-item reveal">
        <span class="partner-name">HVAC</span>
        <span class="partner-role">Seasonal demand, emergency intent</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Electrical</span>
        <span class="partner-role">Service calls and project work</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Construction</span>
        <span class="partner-role">Long consideration, high ticket</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Lawn Care</span>
        <span class="partner-role">Recurring contracts, route density</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Interior Design</span>
        <span class="partner-role">Portfolio-led, referral heavy</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Med Spas</span>
        <span class="partner-role">Repeat treatment, local competition</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Pest Control</span>
        <span class="partner-role">Urgent intent, subscription upsell</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Private Schools</span>
        <span class="partner-role">Enrolment windows, parent targeting</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ WHAT'S DIFFERENT ============ -->
<section class="services" id="approach">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">What's different</p>
    <h2 class="reveal">What a local budget usually buys, and what it buys here.</h2>

    <div class="services-detail-grid">
      <div class="service-detail-card reveal">
        <span class="service-num">01</span>
        <h3>Your market, not a national template</h3>
        <p>Geo, radius, and budget pacing built around your actual service area rather than a national campaign shrunk down.</p>
        <ul class="checklist">
          <li>Service-area geo targeting</li>
          <li>Local competitor analysis</li>
          <li>Seasonal budget pacing</li>
        </ul>
      </div>
      <div class="service-detail-card reveal">
        <span class="service-num">02</span>
        <h3>Daily management, not monthly</h3>
        <p>The same active ads management the enterprise accounts get — budgets and creative adjusted daily.</p>
        <ul class="checklist">
          <li>Daily bid and budget changes</li>
          <li>Creative rotation and testing</li>
          <li>Underperformers cut quickly</li>
        </ul>
      </div>
      <div class="service-detail-card reveal">
        <span class="service-num">03</span>
        <h3>Leads you can actually track</h3>
        <p>Call and form tracking wired up properly, so you know which ads produce booked jobs rather than clicks.</p>
        <ul class="checklist">
          <li>Call and form tracking</li>
          <li>Cost per booked job</li>
          <li>Clear monthly reporting</li>
        </ul>
      </div>
      <div class="service-detail-card reveal">
        <span class="service-num">04</span>
        <h3>Transparent, all-inclusive pricing</h3>
        <p>One fee covering media management and creative production. No percentage-of-spend surprises as you scale.</p>
        <ul class="checklist">
          <li>Flat monthly fee</li>
          <li>Creative production included</li>
          <li>You own every ad account</li>
        </ul>
      </div>
    </div>

    <a href="{{ route('services') }}" class="btn btn-ghost reveal section-more-link">See the full service list</a>
  </div>
</section>

<!-- ============ CONTACT / CTA ============ -->
<section class="contact" id="contact">
  <div class="section-inner contact-inner">
    <h2 class="reveal">Let's look at your market.</h2>
    <p class="reveal">Tell us your service area and what you're spending now. We'll tell you what we'd change first.</p>
    <a href="{{ route('contact') }}" class="btn btn-primary btn-large reveal">Schedule a call</a>
  </div>
</section>

@endsection
