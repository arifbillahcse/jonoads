    <div class="comparison-grid">
      @foreach (\App\Support\SiteContent::comparisonMetrics() as $metric)
      <div class="comparison-card reveal">
        <p class="comparison-title">{{ $metric->title }}</p>
        {{-- The JS builds the bars from these attributes, in this order, and
             gives the accent treatment to whichever row data-highlight names.
             Ours goes first so it reads above the average agency's. --}}
        <div class="bar-chart" data-values="{{ (float) $metric->jono_value }},{{ (float) $metric->baseline_value }}" data-labels="{{ $metric->jono_label }},{{ $metric->baseline_label }}" data-highlight="0" data-suffix="{{ $metric->suffix }}"></div>
      </div>
      @endforeach
    </div>

    <ul class="checklist reveal">
      @foreach (\App\Support\SiteContent::comparisonChecks() as $check)
      <li>{{ $check->text }}</li>
      @endforeach
    </ul>
