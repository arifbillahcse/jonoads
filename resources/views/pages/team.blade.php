@extends('layouts.app')

@section('title', "Team — Jono Advertising")
@section('description', 'Meet the Jono Advertising team: a founder with $250M in media managed, and department leads in client success, CRM, social, creative, and PR.')

@section('content')
<!-- ============ TEAM HERO ============ -->
<section class="engine-hero" id="top">
  <div class="section-inner engine-hero-inner">
    <p class="eyebrow-free-label reveal">The people</p>
    <h1 class="reveal">Industry leaders in every domain.</h1>
    <p class="engine-hero-sub reveal">
      Trusted by startups and mega brands, collectively scaled over 100
      brands — the team every account actually works with, not a rotating
      cast of account managers.
    </p>
    <div class="hero-actions reveal">
      <a href="{{ route('contact') }}" class="btn btn-primary">Schedule a call</a>
      <a href="#dream-team" class="btn btn-ghost">Meet the team</a>
    </div>

    <div class="hero-stats reveal">
      <div class="hero-stat">
        <span class="stat-number" data-target="100" data-suffix="+">0</span>
        <span class="stat-label">Combined years at mega brands</span>
      </div>
      <div class="hero-stat">
        <span class="stat-number" data-target="40" data-suffix="+">0</span>
        <span class="stat-label">Brands scaled</span>
      </div>
      <div class="hero-stat">
        <span class="stat-number" data-target="7" data-suffix="">0</span>
        <span class="stat-label">Billion-dollar clients</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ FOUNDER ============ -->
<section class="team" id="founder">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Founder &amp; CEO</p>

    <div class="founder reveal">
      <div class="founder-photo" data-initials="J" aria-hidden="true"></div>
      <div class="founder-copy">
        <h2>Joseph</h2>
        <p>Among the world's most experienced digital advertising professionals, with $250M in media managed, ~$750M in revenue generated, and over 150,000 ads launched. He's scaled 30+ brands, managed media for seven billion-dollar companies, and worked with 70+ brands total.</p>
        <p>Acclaimed for paid social advertising, Joseph has doubled client ROAS and monthly budget more than twenty times, and is undefeated against the marketing science teams at the top ad networks for eight consecutive years — nineteen pitches, zero losses.</p>
        <p>He spent roughly 14 years at billion-dollar brands and is the first two-time recipient of the Brand Innovator Top 40 Under 40 Award. Joseph has spoken at Dreamforce, Spreadfast Summit, Social Loco, Mobile Loco, and the Corporate Social Media Summit, and regularly lectures in MBA programs at USC, Columbia, and George Washington University.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ DREAM TEAM ============ -->
<section class="team" id="dream-team">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Dream team</p>
    <h2 class="reveal">One team, no handoffs.</h2>
    <p class="team-sub reveal">Every discipline an account touches — media, creative, CRM, PR, and advisory — sits inside the same team.</p>

    <div class="team-grid">
      <div class="team-card reveal">
        <div class="team-photo" data-initials="MS" aria-hidden="true"></div>
        <h3>Mike Smart</h3>
        <p class="team-role">Head of Client Success</p>
        <p>Go-to-market expert with two decades launching the world's most popular consumer electronics and Apple ecosystem brands. Deep manufacturer and retailer relationships across the US and Southeast Asia.</p>
      </div>
      <div class="team-card reveal">
        <div class="team-photo" data-initials="PI" aria-hidden="true"></div>
        <h3>Phil Irvine</h3>
        <p class="team-role">CRM + Lifecycle</p>
        <p>Transformational marketing executive with two decades driving DTC and omni-channel growth from early stage to $1B+ organizations. Named one of Business Insider's "42 Rising Stars in Adtech."</p>
      </div>
      <div class="team-card reveal">
        <div class="team-photo" data-initials="NH" aria-hidden="true"></div>
        <h3>Nicole Hidalgo</h3>
        <p class="team-role">Social Media + Content</p>
        <p>Founder of 197, a strategy-first creative growth agency aligning positioning, messaging, creative, and performance into one operating system built for scale.</p>
      </div>
      <div class="team-card reveal">
        <div class="team-photo" data-initials="TP" aria-hidden="true"></div>
        <h3>Tom Pelligrino</h3>
        <p class="team-role">Creative Engineer</p>
        <p>A decade at premier brand-creative agencies, transforming messaging and identity for national clients. Two-plus years at the forefront of AI for creative strategy and performance advertising.</p>
      </div>
      <div class="team-card reveal">
        <div class="team-photo" data-initials="BB" aria-hidden="true"></div>
        <h3>Bill Bradford</h3>
        <p class="team-role">Advisor + Executive Leadership</p>
        <p>Recognized executive leader in eCommerce and digital transformation, having led large, profitable digital divisions at Fox, Beachbody, AOL, Yahoo!, Oracle, and Wondr Health.</p>
      </div>
      <div class="team-card reveal">
        <div class="team-photo" data-initials="ND" aria-hidden="true"></div>
        <h3>Nicole Dunn</h3>
        <p class="team-role">Public Relations, CEO of DPM PR</p>
        <p>Founded DPM PR to bring positive health coverage to media. The firm elevates brands, experts, and healthcare providers in health, wellness, and lifestyle — and regularly contributes to Forbes.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ PARTNER NETWORK TEASER ============ -->
<section class="partners" id="partners">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">World-class partner network</p>
    <h2 class="reveal">We don't do everything. We know who does.</h2>

    <div class="partner-grid">
      <div class="partner-item reveal">
        <span class="partner-name">197</span>
        <span class="partner-role">Social Media + Content</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">DPM PR</span>
        <span class="partner-role">Public Relations</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Stickybeak</span>
        <span class="partner-role">Research</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Databox</span>
        <span class="partner-role">Measurement</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Studio X</span>
        <span class="partner-role">Web Development</span>
      </div>
      <div class="partner-item reveal">
        <span class="partner-name">Catalyst Consulting</span>
        <span class="partner-role">Product Dev + GTM</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ CONTACT / CTA ============ -->
<section class="contact" id="contact">
  <div class="section-inner contact-inner">
    <h2 class="reveal">Want to work with this team?</h2>
    <p class="reveal">Tell us about your brand and your media spend. We'll tell you what we'd change first.</p>
    <a href="{{ route('contact') }}" class="btn btn-primary btn-large reveal">Schedule a call</a>
  </div>
</section>
@endsection
