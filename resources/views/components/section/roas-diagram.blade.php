{{--
  The client's own official ROAS Engine graphic, swapped in for the
  previous hand-drawn SVG ring. It's a single flat image, so the active
  step can't be shown by recoloring it directly — instead a transparent
  SVG overlay sits on top, pixel-measured to match this exact image's
  ring (center, radius, and the three segments' angles), and draws a
  glow arc over whichever segment is active. JS positions and sweeps it
  the same way the old hand-drawn ring's arcs worked.
--}}
<div class="roas-diagram-wrap reveal">
  <div class="roas-diagram-stack">
    <img
      id="roasDiagram"
      src="{{ asset('placeholders/roas-engine-graphic.webp') }}"
      alt="The ROAS Engine cycle: Review, Operate, Improve"
      class="roas-diagram-image"
      width="2000"
      height="2000"
      loading="lazy"
    >
    <svg class="roas-diagram-overlay" viewBox="0 0 2000 2000" aria-hidden="true">
      <path class="roas-glow-arc roas-glow-arc-1" data-step="1" d="" />
      <path class="roas-glow-arc roas-glow-arc-2" data-step="2" d="" />
      <path class="roas-glow-arc roas-glow-arc-3" data-step="3" d="" />
      <circle class="roas-spark" id="roasSpark" r="10" opacity="0" />
    </svg>
  </div>
</div>
