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

    <div class="services-detail-grid">
      <div class="service-detail-card reveal">
        <span class="service-num">01</span>
        <h3>Digital Advertising</h3>
        <p>Media planning, optimization, and attribution run by buyers who've managed nine figures in spend.</p>
        <ul class="checklist">
          <li>Meta, Google, TikTok, X, Reddit</li>
          <li>CTV, podcasts, and Pinterest</li>
          <li>Daily bid and budget management</li>
          <li>Cross-channel attribution</li>
        </ul>
      </div>
      <div class="service-detail-card reveal">
        <span class="service-num">02</span>
        <h3>Creative Services</h3>
        <p>Concept to production, integrated directly with your internal team.</p>
        <ul class="checklist">
          <li>Creative brief and concepting</li>
          <li>Asset production</li>
          <li>Direct integration with your team</li>
          <li>Performance data feeds the next round</li>
        </ul>
      </div>
      <div class="service-detail-card reveal">
        <span class="service-num">03</span>
        <h3>CMO Advisory</h3>
        <p>The full-funnel best practices we've used to future-proof media programs at billion-dollar brands.</p>
        <ul class="checklist">
          <li>Business alignment</li>
          <li>Competitive intelligence</li>
          <li>Operational improvements</li>
          <li>Full-funnel strategy</li>
        </ul>
      </div>
      <div class="service-detail-card reveal">
        <span class="service-num">04</span>
        <h3>CRM Strategy</h3>
        <p>Email, SMS, and lifecycle work — plus the creative production to actually ship the campaigns.</p>
        <ul class="checklist">
          <li>Email and SMS optimization</li>
          <li>Database monetization</li>
          <li>Customer journey mapping</li>
          <li>Campaign creative production</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ ENGAGEMENT MODELS ============ -->
<section class="engagement" id="engagement">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">How we work together</p>
    <h2 class="reveal">Three ways in. Pick what fits.</h2>

    <div class="engagement-grid">
      <div class="engagement-card reveal">
        <h3>Media Management</h3>
        <ul>
          <li>Omni-channel media buying — planning, daily optimization</li>
          <li>Performance reporting across media and creative</li>
          <li>Creative strategy and production with your team</li>
          <li>Weekly meetings, historical review, forward planning</li>
        </ul>
      </div>
      <div class="engagement-card reveal">
        <h3>Team Augment</h3>
        <ul>
          <li>Fixed term, side-by-side training</li>
          <li>Knowledge exchange on media, creative, attribution</li>
          <li>Enhanced reporting and stakeholder management</li>
          <li>Creative development support</li>
        </ul>
      </div>
      <div class="engagement-card reveal">
        <h3>Media Audit</h3>
        <ul>
          <li>360-degree review of every paid media channel</li>
          <li>Ad tech, account architecture, creative, attribution</li>
          <li>Findings plus a plan of actionable next steps</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ COMPARISON ============ -->
<section class="comparison" id="comparison">
  <div class="section-inner">
    <h2 class="reveal">Jono vs. the average agency.</h2>
    <p class="comparison-sub reveal">There's no comparison. We check every box.</p>

    <div class="comparison-grid">
      <div class="comparison-card reveal">
        <p class="comparison-title">Outperformed client's previous team</p>
        <div class="bar-chart" data-values="33,100" data-labels="Avg agency,Jono" data-suffix="%"></div>
      </div>
      <div class="comparison-card reveal">
        <p class="comparison-title">Clients whose ROAS we increased 25%+</p>
        <div class="bar-chart" data-values="25,99" data-labels="Avg agency,Jono" data-suffix="%"></div>
      </div>
      <div class="comparison-card reveal">
        <p class="comparison-title">Career ad spend managed by your buyer ($M)</p>
        <div class="bar-chart" data-values="2,250" data-labels="Avg agency,Jono" data-suffix="M"></div>
      </div>
      <div class="comparison-card reveal">
        <p class="comparison-title">Years experience of your media buyer</p>
        <div class="bar-chart" data-values="4,28" data-labels="Avg agency,Jono" data-suffix=""></div>
      </div>
    </div>

    <ul class="checklist reveal">
      <li>Only world-class talent</li>
      <li>10x the experience of a typical agency team</li>
      <li>A-list partner network</li>
      <li>Transparency is our standard</li>
      <li>All-inclusive pricing — you win, we win</li>
      <li>24/7 access</li>
    </ul>
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
