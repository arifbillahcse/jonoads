@extends('layouts.app')

@section('title', "Services — Jono Advertising")
@section('description', 'Four services, one team: digital advertising, creative services, CMO advisory, and CRM strategy — plus three ways to work with Jono Advertising.')

@section('content')
<!-- ============ SERVICES HERO ============ -->
<section class="engine-hero" id="top">
  <div class="section-inner engine-hero-inner">
    <p class="eyebrow-free-label reveal">What we do</p>
    <h1 class="reveal">Four services. One team, no handoffs.</h1>
    <p class="engine-hero-sub reveal">
      Media, creative, advisory, and CRM — run by the same people who see
      the performance data, so nothing gets lost translating between an
      agency and three subcontractors.
    </p>
    <div class="hero-actions reveal">
      <a href="{{ route('contact') }}" class="btn btn-primary">Schedule a call</a>
      <a href="#engagement" class="btn btn-ghost">How we work together</a>
    </div>
  </div>
</section>

<!-- ============ SERVICES DETAIL ============ -->
<section class="services" id="services-detail">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">The services</p>
    <h2 class="reveal">What's included in each.</h2>

    <x-section.services-detail />
  </div>
</section>

<!-- ============ ENGAGEMENT MODELS ============ -->
<section class="engagement" id="engagement">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">How we work together</p>
    <h2 class="reveal">Three ways in. Pick what fits.</h2>

    <x-section.engagement />
  </div>
</section>

<!-- ============ COMPARISON ============ -->
<section class="comparison" id="comparison">
  <div class="section-inner">
    <h2 class="reveal">Jono vs. the average agency.</h2>
    <p class="comparison-sub reveal">There's simply no comparison.</p>

    <x-section.comparison />
  </div>
</section>

<!-- ============ CONTACT / CTA ============ -->
<section class="contact" id="contact">
  <div class="section-inner contact-inner">
    <h2 class="reveal">Not sure which service fits?</h2>
    <p class="reveal">Tell us about your brand and your media spend. We'll tell you what we'd change first.</p>
    <a href="{{ route('contact') }}" class="btn btn-primary btn-large reveal">Schedule a call</a>
  </div>
</section>
@endsection
