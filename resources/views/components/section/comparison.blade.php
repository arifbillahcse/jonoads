    <div class="comparison-grid">
      @foreach (\App\Support\SiteContent::comparisonMetrics() as $metric)
      <div class="comparison-card reveal">
        <p class="comparison-title">{{ $metric->title }}</p>
        {{-- The JS builds the bars from these attributes; the last value is
             always ours, which is what gets the accent treatment. --}}
        <div class="bar-chart" data-values="{{ (float) $metric->baseline_value }},{{ (float) $metric->jono_value }}" data-labels="{{ $metric->baseline_label }},{{ $metric->jono_label }}" data-suffix="{{ $metric->suffix }}"></div>
      </div>
      @endforeach
    </div>

    <ul class="checklist reveal">
      @foreach (\App\Support\SiteContent::comparisonChecks() as $check)
      <li>{{ $check->text }}</li>
      @endforeach
    </ul>
