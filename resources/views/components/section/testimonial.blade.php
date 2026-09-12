@php($testimonial = \App\Support\SiteContent::featuredTestimonial())
@if ($testimonial)
<!-- ============ TESTIMONIAL ============ -->
<section class="testimonial" id="testimonial">
  <div class="section-inner">
    <blockquote class="reveal">
      <p>"{{ $testimonial->quote }}"</p>
      <footer>{{ $testimonial->attribution }}</footer>
    </blockquote>
  </div>
</section>
@endif
