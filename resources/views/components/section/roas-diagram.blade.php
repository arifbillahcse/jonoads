@php($first = \App\Support\SiteContent::roasSteps()->first())
    <div class="roas-diagram-wrap reveal">
      {{-- The arc paths are drawn by JS from the step count; the markup only
           has to provide the slots and the centre label. --}}
      <svg class="roas-diagram" id="roasDiagram" viewBox="0 0 400 400" role="img" aria-label="The ROAS Engine cycle: Review, Operate, Improve">
        <circle class="roas-ring-track" cx="200" cy="200" r="160" />
        <path class="roas-arc roas-arc-1" data-step="1" d="" />
        <path class="roas-arc roas-arc-2" data-step="2" d="" />
        <path class="roas-arc roas-arc-3" data-step="3" d="" />
        <text class="roas-center-label" x="200" y="188" text-anchor="middle">ROAS</text>
        <text class="roas-center-sub" x="200" y="210" text-anchor="middle">ENGINE™</text>
        <text class="roas-center-step" id="roasCenterStep" x="200" y="234" text-anchor="middle">{{ $first ? str_pad((string) $first->number, 2, '0', STR_PAD_LEFT) . ' · ' . strtoupper($first->title) : '' }}</text>
      </svg>
    </div>
