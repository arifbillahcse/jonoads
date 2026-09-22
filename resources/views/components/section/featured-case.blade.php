@php
    $case = \App\Support\SiteContent::featuredCase();
    $headline = $case?->headlineStat();
@endphp
@if ($case && filled($case->detail))
<!-- ============ FEATURED CASE ============ -->
<section class="featured-case">
  <div class="section-inner featured-case-inner">
    <div class="featured-case-copy">
      <p class="eyebrow-free-label reveal">Featured case</p>
      <h2 class="reveal">{{ $case->client }}@if ($headline): {{ $headline->displayValue() }} {{ $headline->label }}.@endif</h2>
      @foreach ($case->detailParagraphs() as $paragraph)
      <p class="reveal">{{ $paragraph }}</p>
      @endforeach

      <x-case-video-button :case="$case" class="reveal" />
    </div>
    @if ($headline)
    <div class="featured-case-chart reveal">
      <p class="comparison-title">Before vs. after the Engine</p>
      {{-- Baseline is 1x — where the account sat before the Engine ran. --}}
      <div class="bar-chart" data-values="1,{{ $headline->animationTarget() }}" data-labels="Before,After" data-suffix="{{ $headline->suffix }}"></div>
    </div>
    @endif
  </div>
</section>
@endif
