@php($testimonials = \App\Support\SiteContent::testimonials())
@if ($testimonials->isNotEmpty())
<!-- ============ TESTIMONIAL ============ -->
<section class="testimonial" id="testimonial">
  <div class="section-inner">
    <h2 class="testimonial-heading reveal">Client Testimonials</h2>
    {{--
      Every quote is in the markup; the JS shows one at a time and rotates
      between them. With JavaScript off, or before it runs, they simply stack
      and all stay readable — nothing is hidden by inline styles.
    --}}
    <div class="testimonial-carousel" data-testimonial-carousel data-interval="4000">
      @if ($testimonials->count() > 1)
      <button type="button" class="testimonial-arrow testimonial-arrow-prev" data-testimonial-prev aria-label="Previous quote">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      @endif

      <div class="testimonial-content">
        <div class="testimonial-slides" aria-live="polite">
          @foreach ($testimonials as $testimonial)
          <blockquote class="testimonial-slide" @if (! $loop->first) hidden @endif>
            <p>"{{ $testimonial->quote }}"</p>
            <footer>{{ $testimonial->attribution }}</footer>
          </blockquote>
          @endforeach
        </div>

        @if ($testimonials->count() > 1)
        <div class="testimonial-dots" role="tablist" aria-label="Choose a client quote">
          @foreach ($testimonials as $testimonial)
          <button
            type="button"
            class="testimonial-dot @if ($loop->first) is-active @endif"
            role="tab"
            aria-selected="{{ $loop->first ? 'true' : 'false' }}"
            aria-label="Quote {{ $loop->iteration }} of {{ $testimonials->count() }}"
          ></button>
          @endforeach
        </div>
        @endif
      </div>

      @if ($testimonials->count() > 1)
      <button type="button" class="testimonial-arrow testimonial-arrow-next" data-testimonial-next aria-label="Next quote">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      @endif
    </div>
  </div>
</section>
@endif
