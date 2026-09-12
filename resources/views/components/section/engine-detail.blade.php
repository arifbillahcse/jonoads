    <div class="engine-detail-grid">
      @foreach (\App\Support\SiteContent::roasSteps() as $step)
      <div class="engine-detail-card reveal">
        <span class="engine-detail-num">{{ str_pad((string) $step->number, 2, '0', STR_PAD_LEFT) }}</span>
        <h3>{{ $step->title }}</h3>
        <p>{{ $step->detail ?: $step->summary }}</p>
        <ul class="checklist">
          @foreach ($step->features as $feature)
          <li>{{ $feature->text }}</li>
          @endforeach
        </ul>
      </div>
      @endforeach
    </div>
