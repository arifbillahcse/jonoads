@php($testimonials = \App\Support\SiteContent::testimonials())
@if ($testimonials->isNotEmpty())
<!-- ============ TESTIMONIAL ============ -->
<section class="testimonial" id="testimonial">
  <div class="section-inner">
    {{--
      Every quote is in the markup; the JS shows one at a time and rotates
      between them. With JavaScript off, or before it runs, they simply stack
      and all stay readable — nothing is hidden by inline styles.
    --}}
    <div class="testimonial-carousel" data-testimonial-carousel data-interval="4000">
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
  </div>
</section>
@endif
