@extends('layouts.app')

@section('title', "Jono Advertising — Performance advertising, engineered to win.")
@section('description', 'Jono Advertising manages $250M+ in media, has generated $750M+ in client revenue, and runs the ROAS Engine — a media buying system built for billion-dollar brands.')

@section('content')
<!-- ============ HERO ============ -->
<section class="hero" id="top">
  <canvas id="heroCanvas" class="hero-canvas"></canvas>

  <div class="hero-inner">
    {{-- Breaks are placed by hand, as they were before: the headline is
         capped at 15ch, so leaving them to the browser puts "confidence."
         alone on a line in some fonts. --}}
    <h1 class="hero-headline">
      Scale your brand<br>
      with confidence.<br>
      <span class="accent-text">Win.</span>
    </h1>
    <p class="hero-sub">
      The trusted choice. Outperformed every client and ad network team for
      8 years. 40+ brands scaled.
    </p>
    <div class="hero-actions">
      <a href="{{ route('contact') }}" class="btn btn-primary">Schedule a call</a>
      <a href="{{ route('roas-engine') }}" class="btn btn-ghost">See the ROAS Engine</a>
    </div>

    <x-section.hero-stats group="home_hero" id="heroStats" />
  </div>

  <div class="scroll-cue" aria-hidden="true">
    <span></span>
  </div>
</section>

<!-- ============ LOGO MARQUEE ============ -->
<section class="marquee-section" aria-label="Brands we've worked with">
  <x-section.marquee />
</section>

<!-- ============ PEDIGREE STATS ============ -->
<section class="pedigree" id="pedigree">
  <div class="section-inner">
    <h2 class="reveal">Only elite talent works here.</h2>
    <p class="pedigree-sub reveal">
      Trusted by mega brands and premier startups. Our media buyers have run
      ads for brands most agencies dream about.
    </p>

    <x-section.pedigree />
  </div>
</section>

<!-- ============ ROAS ENGINE ============ -->
<section class="roas-engine" id="roas-engine">
  <div class="section-inner roas-grid">
    <div class="roas-copy">
      <p class="eyebrow-free-label reveal">The ROAS Engine™</p>
      <h2 class="reveal">A media buying system, not a guessing game.</h2>
      <p class="roas-intro reveal">
        Every client receives the same 3-phase approach tailored to its
        specific business. This isn't a one-size-fits-all fixed playbook.
        That's why we've outperformed the marketing science teams at top ad
        networks for eight consecutive years. Twenty-four contests, zero losses.
      </p>

      <x-section.roas-steps />

      <a href="{{ route('roas-engine') }}" class="btn btn-ghost reveal roas-more-link">Read the full breakdown</a>
    </div>

    <x-section.roas-diagram />
  </div>
</section>

<!-- ============ SERVICES ============ -->
<section class="services" id="services">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">What we do</p>
    <h2 class="reveal">World-class services.</h2>

    <x-section.services-list />

    <a href="{{ route('services') }}" class="btn btn-ghost reveal section-more-link">See all services</a>
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

<x-section.testimonial />

<!-- ============ TEAM ============ -->
<section class="team" id="team">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Founder &amp; CEO</p>

    <x-section.founder />

    <p class="eyebrow-free-label reveal team-heading-spacer">Dream team</p>
    <h2 class="reveal">Industry leaders in every domain.</h2>
    <p class="team-sub reveal">Trusted by startups and mega brands. Collectively scaled over 100 brands.</p>

    <x-section.team-grid />
  </div>
</section>

<!-- ============ CASE STUDIES ============ -->
<section class="case-studies" id="work">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Results</p>
    <h2 class="reveal">Case studies, by request.</h2>
    <p class="case-sub reveal">A sample of what changing the account architecture, creative, and management model actually does to the numbers.</p>

    <x-section.case-grid />

    <a href="{{ route('work') }}" class="btn btn-ghost reveal section-more-link">See all case studies</a>
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

<!-- ============ PARTNER NETWORK ============ -->
<section class="partners" id="partners">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">World-class partner network</p>
    <h2 class="reveal">We don't do everything. We know who does.</h2>

    <x-section.partner-grid />
  </div>
</section>

<!-- ============ LOCATIONS ============ -->
<section class="locations" id="locations">
  <div class="section-inner">
    <p class="eyebrow-free-label reveal">Small team. Big impact.</p>
    <h2 class="reveal">Cross cultures and time zones. We understand people.</h2>

    <x-section.locations />
  </div>
</section>

<!-- ============ SMB CALLOUT ============ -->
<section class="smb-callout" id="smb">
  <div class="section-inner smb-inner reveal">
    <div>
      <h2>Running a local or regional business?</h2>
      <p>HVAC, electricians, construction, lawn care, interior design, med spas, pest control, private schools — we run a dedicated program built for your budget and your market.</p>
    </div>
    <a href="{{ route('smb') }}" class="btn btn-primary">See the SMB program</a>
  </div>
</section>

<!-- ============ CONTACT / CTA ============ -->
<section class="contact" id="contact">
  <div class="section-inner contact-inner">
    <h2 class="reveal">Let's do great things together.</h2>
    <p class="reveal">Tell us about your brand and your media spend. We'll tell you what we'd change first.</p>
    <a href="mailto:info@jonoadvertising.com" class="btn btn-primary btn-large reveal">Schedule a call</a>

    <div class="contact-links reveal">
      <a href="#newsletter">Newsletter</a>
      <a href="https://www.skool.com" target="_blank" rel="noopener">Skool community</a>
      <a href="#podcast">Podcast</a>
      <a href="{{ route('home') }}#merch">Merch</a>
    </div>
  </div>
</section>

<!-- ============ NEWSLETTER ============ -->
<section class="newsletter" id="newsletter">
  <div class="section-inner newsletter-inner reveal">
    <div>
      <h2>Media buying notes, monthly.</h2>
      <p>What's working on Meta, Google, and CTV right now — no fluff, straight from the people running the accounts.</p>
    </div>
    <form class="newsletter-form" id="newsletterForm">
      <input type="email" name="email" placeholder="you@company.com" required aria-label="Email address">
      <button type="submit" class="btn btn-primary">Subscribe</button>
    </form>
    <p class="newsletter-success" id="newsletterSuccess" role="status">You're in. Check your inbox to confirm.</p>
  </div>
</section>
@endsection
