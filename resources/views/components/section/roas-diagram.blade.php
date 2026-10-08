{{--
  The client's own official ROAS Engine graphic, swapped in for the
  previous hand-drawn SVG ring. It's a single flat image rather than
  separate Review/Operate/Improve layers, so it can't be recolored per
  active step the way the SVG was — the step list beside it still
  highlights on hover/click/auto-advance exactly as before, independent
  of this image, which just sits still underneath a soft glow.
--}}
<div class="roas-diagram-wrap reveal">
  <img
    id="roasDiagram"
    src="{{ asset('placeholders/roas-engine-graphic.webp') }}"
    alt="The ROAS Engine cycle: Review, Operate, Improve"
    class="roas-diagram-image"
    width="2000"
    height="2000"
    loading="lazy"
  >
</div>
