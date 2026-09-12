    <div class="locations-grid">
      @foreach (\App\Support\SiteContent::locations() as $location)
      <div class="location-item reveal">
        <h3>{{ $location->city }}@if ($location->badge) <span>{{ $location->badge }}</span>@endif</h3>
        <p>{{ $location->discipline }}</p>
      </div>
      @endforeach
    </div>
