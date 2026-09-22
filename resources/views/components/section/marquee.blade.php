  <div class="marquee-track" id="marqueeTrack">
    <div class="marquee-group" id="marqueeGroup">
      {{--
        A brand shows its logo once one is uploaded and its name until then,
        so the strip can fill in one logo at a time rather than all at once.
      --}}
      @foreach (\App\Support\SiteContent::brandLogos() as $logo)
        @if ($logo->image_path)
        <span class="marquee-item">
          <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($logo->image_path) }}" alt="{{ $logo->name }}" class="marquee-logo" loading="lazy">
        </span>
        @else
        <span class="marquee-item">{{ $logo->name }}</span>
        @endif
      @endforeach
    </div>
  </div>
