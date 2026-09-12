    <div class="partner-grid">
      @foreach (\App\Support\SiteContent::partners() as $partner)
      <div class="partner-item reveal">
        <span class="partner-name">{{ $partner->name }}</span>
        <span class="partner-role">{{ $partner->category }}</span>
      </div>
      @endforeach
    </div>
