@extends('layouts.app')

@section('title', "Work — Jono Advertising case studies")
@section('description', 'Case studies from Jono Advertising: real accounts, real budget and ROAS numbers, across sunglasses, lenses, lead gen, supplements, spirits, and fitness apps.')

@section('content')
<!-- ============ WORK HERO ============ -->
<section class="engine-hero" id="top">
  <div class="section-inner engine-hero-inner">
    <p class="eyebrow-free-label reveal">Results</p>
    <h1 class="reveal">Real accounts. Real numbers.</h1>
    <p class="engine-hero-sub reveal">
      A sample of what changing the account architecture, creative, and
      management model actually does to the numbers — available in full
      detail by request.
    </p>
    <div class="hero-actions reveal">
      <a href="{{ route('contact') }}" class="btn btn-primary">Schedule a call</a>
      <a href="#cases" class="btn btn-ghost">See the case studies</a>
    </div>
  </div>
</section>

<!-- ============ CASE STUDIES ============ -->
<section class="case-studies" id="cases">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Case studies</p>
    <h2 class="reveal">Case studies, by request.</h2>
    <p class="case-sub reveal">A sample of what changing the account architecture, creative, and management model actually does to the numbers.</p>

    <x-section.case-grid />
  </div>
</section>

<x-section.featured-case />

<x-section.testimonial />

<!-- ============ CONTACT / CTA ============ -->
<section class="contact" id="contact">
  <div class="section-inner contact-inner">
    <h2 class="reveal">Want to see the full numbers?</h2>
    <p class="reveal">Tell us about your brand and your media spend. We'll tell you what we'd change first.</p>
    <a href="{{ route('contact') }}" class="btn btn-primary btn-large reveal">Schedule a call</a>
  </div>
</section>
@endsection
