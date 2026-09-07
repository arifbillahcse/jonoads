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

    <div class="case-grid">
      <div class="case-card reveal">
        <h3>Sunglasses Co.</h3>
        <div class="case-stats">
          <div class="case-stat">
            <span class="case-stat-number" data-target="7.5" data-decimals="1" data-suffix="x">0x</span>
            <span class="case-stat-label">Monthly budget</span>
          </div>
          <div class="case-stat">
            <span class="case-stat-number" data-target="40" data-prefix="+" data-suffix="%">0%</span>
            <span class="case-stat-label">ROAS in 4 months</span>
          </div>
        </div>
        <p>Rebuilt Meta audiences and campaign architecture, then switched to active ads management.</p>
      </div>
      <div class="case-card reveal">
        <h3>Lenses Brand</h3>
        <div class="case-stats">
          <div class="case-stat">
            <span class="case-stat-number" data-target="4" data-suffix="x">0x</span>
            <span class="case-stat-label">Monthly budget</span>
          </div>
          <div class="case-stat">
            <span class="case-stat-number" data-target="30" data-prefix="+" data-suffix="%">0%</span>
            <span class="case-stat-label">ROAS</span>
          </div>
        </div>
        <p>Reduced campaign overlap, rebuilt audiences, added active ads management and a creative testing pipeline. Revenue up +30% YoY.</p>
      </div>
      <div class="case-card reveal">
        <h3>Global App (Lead Gen)</h3>
        <div class="case-stats">
          <div class="case-stat">
            <span class="case-stat-number" data-target="20" data-prefix="$" data-suffix="">$0</span>
            <span class="case-stat-label">Cost per lead, down from ~$385</span>
          </div>
        </div>
        <p>Updated the lead page, added martech, new Meta and Google creative and campaigns, sunset underperforming display ads.</p>
      </div>
      <div class="case-card reveal">
        <h3>Supplement Co.</h3>
        <div class="case-stats">
          <div class="case-stat">
            <span class="case-stat-number" data-target="3" data-suffix="x">0x</span>
            <span class="case-stat-label">Budget</span>
          </div>
          <div class="case-stat">
            <span class="case-stat-number" data-target="3" data-suffix="x">0x</span>
            <span class="case-stat-label">ROAS in 45 days</span>
          </div>
        </div>
        <p>Outperformed the incumbent top US agency. New Meta and Google structure, active management, all-new creative and landing page.</p>
      </div>
      <div class="case-card reveal">
        <h3>Non-Alcoholic Whiskey</h3>
        <div class="case-stats">
          <div class="case-stat">
            <span class="case-stat-number" data-target="18" data-suffix="x">0x</span>
            <span class="case-stat-label">Monthly budget</span>
          </div>
          <div class="case-stat">
            <span class="case-stat-number" data-target="2" data-suffix="x">0x</span>
            <span class="case-stat-label">ROAS</span>
          </div>
        </div>
        <p>Beat a global top Google ads agency by 70% on ROAS with new campaign structure, creative, and active management.</p>
      </div>
      <div class="case-card reveal">
        <h3>Fitness App</h3>
        <div class="case-stats">
          <div class="case-stat">
            <span class="case-stat-number" data-target="3" data-suffix="x">0x</span>
            <span class="case-stat-label">ROAS</span>
          </div>
          <div class="case-stat">
            <span class="case-stat-number" data-target="2" data-suffix="x">0x</span>
            <span class="case-stat-label">Monthly budget</span>
          </div>
        </div>
        <p>Displaced a large incumbent US agency. New campaign structures, landing pages, 100% new creative, active management.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FEATURED CASE ============ -->
<section class="featured-case">
  <div class="section-inner featured-case-inner">
    <div class="featured-case-copy">
      <p class="eyebrow-free-label reveal">Featured case</p>
      <h2 class="reveal">Supplement Co.: 3x ROAS in 45 days.</h2>
      <p class="reveal">
        The incumbent agency — a top-10 US shop — had the account on a
        monthly optimization cadence with a single stale campaign structure.
        We rebuilt the Meta and Google account architecture from scratch,
        moved to daily active management, and shipped all-new creative and
        a rebuilt landing page in the first two weeks.
      </p>
      <p class="reveal">
        Budget scaled 3x and ROAS tripled inside 45 days, outperforming the
        prior team's best month on record.
      </p>
    </div>
    <div class="featured-case-chart reveal">
      <p class="comparison-title">ROAS, before vs. after the Engine</p>
      <div class="bar-chart" data-values="1,3" data-labels="Before,After 45 days" data-suffix="x"></div>
    </div>
  </div>
</section>

<!-- ============ TESTIMONIAL ============ -->
<section class="testimonial" id="testimonial">
  <div class="section-inner">
    <blockquote class="reveal">
      <p>"Their digital ads expertise is superior. They have integrity, always
      transparent. Jono is fully invested in our success. I don't have to
      worry about our digital ads anymore — I don't have to worry about ads
      performance anymore."</p>
      <footer>Client feedback</footer>
    </blockquote>
  </div>
</section>

<!-- ============ CONTACT / CTA ============ -->
<section class="contact" id="contact">
  <div class="section-inner contact-inner">
    <h2 class="reveal">Want to see the full numbers?</h2>
    <p class="reveal">Tell us about your brand and your media spend. We'll tell you what we'd change first.</p>
    <a href="{{ route('contact') }}" class="btn btn-primary btn-large reveal">Schedule a call</a>
  </div>
</section>
@endsection
