    <div class="partner-grid">
      @foreach (\App\Support\SiteContent::industries() as $industry)
      <div class="partner-item reveal">
        <span class="partner-name">{{ $industry->name }}</span>
        <span class="partner-role">{{ $industry->note }}</span>
      </div>
      @endforeach
    </div>
