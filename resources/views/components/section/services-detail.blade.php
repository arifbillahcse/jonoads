    <div class="services-detail-grid">
      @foreach (\App\Support\SiteContent::services() as $service)
      <div class="service-detail-card reveal">
        <span class="service-num">{{ $service->number }}</span>
        <h3>{{ $service->title }}</h3>
        <p>{{ $service->detail ?: $service->summary }}</p>
        <ul class="checklist">
          @foreach ($service->features as $feature)
          <li>{{ $feature->text }}</li>
          @endforeach
        </ul>
      </div>
      @endforeach
    </div>
