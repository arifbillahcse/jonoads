      <ol class="roas-steps" id="roasSteps">
        @foreach (\App\Support\SiteContent::roasSteps() as $step)
        <li class="roas-step{{ $loop->first ? ' is-active' : '' }}" data-step="{{ $step->number }}">
          <span class="roas-step-index">
            {{-- Editor-supplied inline SVG, printed unescaped. --}}
            {!! $step->icon_svg !!}
          </span>
          <div>
            <h3>{{ $step->title }}</h3>
            <p>{{ $step->summary }}</p>
          </div>
        </li>
        @endforeach
      </ol>
