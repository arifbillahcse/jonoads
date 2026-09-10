@php($founder = \App\Support\SiteContent::founder())
@if ($founder)
    <div class="founder reveal">
      @if ($founder->photo_path)
      <img class="founder-photo" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($founder->photo_path) }}" alt="{{ $founder->name }}">
      @else
      {{-- No headshot yet, so the card shows initials rather than an empty box. --}}
      <div class="founder-photo" data-initials="{{ $founder->initials }}" aria-hidden="true"></div>
      @endif
      <div class="founder-copy">
        <h2>{{ $founder->name }}</h2>
        @foreach ($founder->bioParagraphs() as $paragraph)
        <p>{{ $paragraph }}</p>
        @endforeach
      </div>
    </div>
@endif
