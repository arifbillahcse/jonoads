@extends('layouts.app')

@section('title', "SMB Program — Jono Advertising")
@section('description', 'A dedicated paid media program for local and regional businesses — HVAC, electrical, construction, lawn care, interior design, med spas, pest control, and private schools.')

@section('content')
@php($smb = \App\Support\SiteContent::smb())

<!-- ============ SMB HERO ============ -->
<section class="engine-hero" id="top">
  <div class="section-inner engine-hero-inner">
    <p class="eyebrow-free-label reveal">{{ $smb?->eyebrow }}</p>
    <h1 class="reveal">{{ $smb?->headline }}</h1>
    <p class="engine-hero-sub reveal">{{ $smb?->intro }}</p>
    <div class="hero-actions reveal">
      <x-cta.schedule class="btn btn-primary" />
      <a href="#industries" class="btn btn-ghost">See who this is for</a>
    </div>
  </div>
</section>

<!-- ============ INDUSTRIES ============ -->
<section class="partners" id="industries">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Who this is for</p>
    <h2 class="reveal">{{ $smb?->industries_heading }}</h2>

    <x-section.industries />
  </div>
</section>

<!-- ============ WHAT'S DIFFERENT ============ -->
<section class="services" id="approach">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">What's different</p>
    <h2 class="reveal">{{ $smb?->approach_heading }}</h2>

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
    <h2 class="reveal">{{ $smb?->cta_heading }}</h2>
    <p class="reveal">{{ $smb?->cta_body }}</p>
    <x-cta.schedule class="btn btn-primary btn-large reveal" />
  </div>
</section>

@endsection
