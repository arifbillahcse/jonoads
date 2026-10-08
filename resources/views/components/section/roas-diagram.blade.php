@php($first = \App\Support\SiteContent::roasSteps()->first())
    <div class="roas-diagram-wrap reveal">
      {{-- The arc paths and the three node positions are drawn by JS from
           the step count; the markup only provides the slots, the node
           icons (fixed — they stand for Review/Operate/Improve regardless
           of whatever copy edits those steps get), and the centre label. --}}
      <svg class="roas-diagram" id="roasDiagram" viewBox="-30 -30 460 460" role="img" aria-label="The ROAS Engine cycle: Review, Operate, Improve">
        <circle class="roas-ring-track" cx="200" cy="200" r="160" />
        <path class="roas-arc roas-arc-1" data-step="1" d="" />
        <path class="roas-arc roas-arc-2" data-step="2" d="" />
        <path class="roas-arc roas-arc-3" data-step="3" d="" />

        <circle class="roas-spark" id="roasSpark" r="5" opacity="0" />

        <g class="roas-node" id="roasNode1" data-step="1">
          <circle class="roas-node-pulse" r="22" />
          <g class="roas-node-inner">
            <circle class="roas-node-bg" r="22" />
            <svg x="-12" y="-12" width="24" height="24" viewBox="0 0 24 24" fill="none" overflow="visible">
              <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.6" />
              <path d="M20 20l-4.8-4.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
            </svg>
          </g>
        </g>

        <g class="roas-node" id="roasNode2" data-step="2">
          <circle class="roas-node-pulse" r="22" />
          <g class="roas-node-inner">
            <circle class="roas-node-bg" r="22" />
            <svg x="-12" y="-12" width="24" height="24" viewBox="0 0 24 24" fill="none" overflow="visible">
              <path d="M4 12h4M16 12h4M12 4v4M12 16v4M6.3 6.3l2.8 2.8M14.9 14.9l2.8 2.8M17.7 6.3l-2.8 2.8M9.1 14.9l-2.8 2.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
              <circle cx="12" cy="12" r="3.2" stroke="currentColor" stroke-width="1.6" />
            </svg>
          </g>
        </g>

        <g class="roas-node" id="roasNode3" data-step="3">
          <circle class="roas-node-pulse" r="22" />
          <g class="roas-node-inner">
            <circle class="roas-node-bg" r="22" />
            <svg x="-12" y="-12" width="24" height="24" viewBox="0 0 24 24" fill="none" overflow="visible">
              <path d="M4 16l5-5.5 3.5 3 6.5-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M15 6h4v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </g>
        </g>

        <text class="roas-center-label" x="200" y="188" text-anchor="middle">ROAS</text>
        <text class="roas-center-sub" x="200" y="210" text-anchor="middle">ENGINE™</text>
        <text class="roas-center-step" id="roasCenterStep" x="200" y="234" text-anchor="middle">{{ $first ? str_pad((string) $first->number, 2, '0', STR_PAD_LEFT) . ' · ' . strtoupper($first->title) : '' }}</text>
      </svg>
    </div>
