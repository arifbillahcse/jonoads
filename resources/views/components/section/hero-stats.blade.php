@props(['group'])
@php($stats = \App\Support\SiteContent::stats($group))
@if ($stats->isNotEmpty())
    <div {{ $attributes->merge(['class' => 'hero-stats']) }}>
      @foreach ($stats as $stat)
      <div class="hero-stat">
        <x-stat-number :stat="$stat" class="stat-number" />
        <span class="stat-label">{{ $stat->label }}</span>
      </div>
      @endforeach
    </div>
@endif
