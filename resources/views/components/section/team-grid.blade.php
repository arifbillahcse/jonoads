    <div class="team-grid">
      @foreach (\App\Support\SiteContent::team() as $member)
      <div class="team-card reveal">
        @if ($member->photo_path)
        <img class="team-photo" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo_path) }}" alt="{{ $member->name }}">
        @else
        <div class="team-photo" data-initials="{{ $member->initials }}" aria-hidden="true"></div>
        @endif
        <h3>{{ $member->name }}</h3>
        <p class="team-role">{{ $member->role }}</p>
        @foreach ($member->bioParagraphs() as $paragraph)
        <p>{{ $paragraph }}</p>
        @endforeach
      </div>
      @endforeach
    </div>
