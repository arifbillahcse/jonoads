{{--
  The client's own official ROAS Engine graphic, swapped in for the
  previous hand-drawn SVG ring. It's a flat image, so true per-segment
  recoloring took pixel-editing it directly rather than a CSS trick:
  three variants were generated from the original (by sampling its own
  pixel colors around the ring to find each segment's exact angle
  range), each with one segment left at full color and the other two
  desaturated/dimmed. JS crossfades between them as the step list is
  hovered, clicked, or auto-advances — the same effect the old
  hand-drawn ring had, just real recolored artwork instead of a CSS
  overlay.
--}}
<div class="roas-diagram-wrap reveal">
  <div class="roas-diagram-stack" id="roasDiagram">
    <img
      data-step="1"
      src="{{ asset('placeholders/roas-engine-active-review.webp') }}"
      alt="The ROAS Engine cycle: Review, Operate, Improve"
      class="roas-diagram-image is-active"
      width="2000"
      height="2000"
      loading="lazy"
    >
    <img
      data-step="2"
      src="{{ asset('placeholders/roas-engine-active-operate.webp') }}"
      alt=""
      aria-hidden="true"
      class="roas-diagram-image"
      width="2000"
      height="2000"
      loading="lazy"
    >
    <img
      data-step="3"
      src="{{ asset('placeholders/roas-engine-active-improve.webp') }}"
      alt=""
      aria-hidden="true"
      class="roas-diagram-image"
      width="2000"
      height="2000"
      loading="lazy"
    >
  </div>
</div>
