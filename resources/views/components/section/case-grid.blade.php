    <div class="case-grid">
      @foreach (\App\Support\SiteContent::caseStudies() as $case)
      <div class="case-card reveal">
        <h3>{{ $case->client }}</h3>
        <div class="case-stats">
          @foreach ($case->stats as $stat)
          <div class="case-stat">
            <x-stat-number :stat="$stat" class="case-stat-number" />
            <span class="case-stat-label">{{ $stat->label }}</span>
          </div>
          @endforeach
        </div>
        <p>{{ $case->summary }}</p>
      </div>
      @endforeach
    </div>
