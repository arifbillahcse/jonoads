    <div class="services-list">
      @foreach (\App\Support\SiteContent::services() as $service)
      <div class="service-row reveal">
        <span class="service-num">{{ $service->number }}</span>
        <div class="service-body">
          <h3>{{ $service->title }}</h3>
          <p>{{ $service->summary }}</p>
        </div>
      </div>
      @endforeach
    </div>
