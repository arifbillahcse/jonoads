  <div class="marquee-track" id="marqueeTrack">
    <div class="marquee-group" id="marqueeGroup">
      @foreach (\App\Support\SiteContent::brandLogos() as $logo)
      <span>{{ $logo->name }}</span>
      @endforeach
    </div>
  </div>
