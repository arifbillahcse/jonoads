@extends('layouts.app')

@section('title', "The ROAS Engine™ — Jono Advertising's media buying system")
@section('description', 'Inside the ROAS Engine™: the three-stage Review, Operate, Improve cycle Jono Advertising runs on every account, built from eight consecutive years undefeated against top ad network marketing science teams.')

@section('content')
<!-- ============ ENGINE HERO ============ -->
<section class="engine-hero" id="top">
  <div class="section-inner engine-hero-inner">
    <p class="eyebrow-free-label reveal">The ROAS Engine™</p>
    <h1 class="reveal">A media buying system, built to never lose.</h1>
    <p class="engine-hero-sub reveal">
      Every account we run — from a $2M DTC brand to a billion-dollar enterprise —
      goes through the same three-stage cycle. It's not a philosophy, it's a
      process, and it's the reason we've beaten the marketing science teams
      at the top ad networks for eight consecutive years: nineteen pitches, zero losses.
    </p>
    <div class="hero-actions reveal">
      <a href="{{ route('contact') }}" class="btn btn-primary">Schedule a call</a>
      <a href="#diagram" class="btn btn-ghost">See how it works</a>
    </div>

    <x-section.hero-stats group="engine_hero" class="reveal" />
  </div>
</section>

<!-- ============ DIAGRAM ============ -->
<section class="roas-engine" id="diagram">
  <div class="section-inner roas-grid">
    <div class="roas-copy">
      <p class="eyebrow-free-label reveal">The cycle</p>
      <h2 class="reveal">Review. Operate. Improve. Repeat.</h2>
      <p class="roas-intro reveal">
        No account skips a stage, and no stage runs in isolation — each one
        feeds the next. Click a step to see how it fits.
      </p>

      <x-section.roas-steps />
    </div>

    <x-section.roas-diagram />
  </div>
</section>

<!-- ============ STAGE BREAKDOWN ============ -->
<section class="engine-detail" id="breakdown">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Inside each stage</p>
    <h2 class="reveal">What actually happens at each step.</h2>
    <p class="engine-detail-sub reveal">A closer look at the work behind each third of the cycle.</p>

    <x-section.engine-detail />
  </div>
</section>

<!-- ============ PROOF STRIP ============ -->
<section class="engine-proof">
  <div class="section-inner engine-proof-inner">
    <div>
      <h2 class="reveal">The Engine, in results.</h2>
      <p class="reveal">A sample of what running through Review, Operate, Improve does to an account.</p>
      <a href="{{ route('work') }}" class="btn btn-ghost reveal">See the full case studies</a>
    </div>
    <div class="engine-proof-stats">
      <div class="case-stat reveal">
        <span class="case-stat-number" data-target="7.5" data-decimals="1" data-suffix="x">0x</span>
        <span class="case-stat-label">Monthly budget scaled</span>
      </div>
      <div class="case-stat reveal">
        <span class="case-stat-number" data-target="40" data-prefix="+" data-suffix="%">0%</span>
        <span class="case-stat-label">ROAS lift in 4 months</span>
      </div>
      <div class="case-stat reveal">
        <span class="case-stat-number" data-target="45" data-suffix=" days">0 days</span>
        <span class="case-stat-label">To 3x ROAS for one client</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ CONTACT / CTA ============ -->
<section class="contact" id="contact">
  <div class="section-inner contact-inner">
    <h2 class="reveal">Ready to put your account through the Engine?</h2>
    <p class="reveal">Tell us about your brand and your media spend. We'll tell you what we'd change first.</p>
    <a href="{{ route('contact') }}" class="btn btn-primary btn-large reveal">Schedule a call</a>
  </div>
</section>
@endsection
