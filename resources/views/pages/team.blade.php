@extends('layouts.app')

@section('title', "Team — Jono Advertising")
@section('description', 'Meet the Jono Advertising team: a founder with $250M in media managed, and department leads in client success, CRM, social, creative, and PR.')

@section('content')
<!-- ============ TEAM HERO ============ -->
<section class="engine-hero" id="top">
  <div class="section-inner engine-hero-inner">
    <p class="eyebrow-free-label reveal">The people</p>
    <h1 class="reveal">Industry Leaders In Every Domain.</h1>
    <p class="engine-hero-sub reveal">
      Trusted by startups and mega brands, collectively scaled over 100
      brands — the team every account actually works with, not a rotating
      cast of account managers.
    </p>
    <div class="hero-actions reveal">
      <x-cta.schedule class="btn btn-primary" />
      <a href="#dream-team" class="btn btn-ghost">Meet the team</a>
    </div>

    <x-section.hero-stats group="team_hero" class="reveal" />
  </div>
</section>

<!-- ============ FOUNDER ============ -->
<section class="team" id="founder">
  <div class="section-inner">
    <x-section.founder />
  </div>
</section>

<!-- ============ DREAM TEAM ============ -->
<section class="team" id="dream-team">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Dream team</p>
    <h2 class="reveal">One Team, No Handoffs.</h2>
    <p class="team-sub reveal">Every discipline an account touches — media, creative, CRM, PR, and advisory — sits inside the same team.</p>

    <x-section.team-grid />
  </div>
</section>

<!-- ============ PARTNER NETWORK TEASER ============ -->
<section class="partners" id="partners">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">World-class partner network</p>
    <h2 class="reveal">We Don't Do Everything. We Know Who Does.</h2>

    <x-section.partner-grid />
  </div>
</section>

<!-- ============ CONTACT / CTA ============ -->
<section class="contact" id="contact">
  <div class="section-inner contact-inner">
    <h2 class="reveal">Want To Work With This Team?</h2>
    <x-cta.schedule class="btn btn-primary btn-large reveal" />
  </div>
</section>
@endsection
