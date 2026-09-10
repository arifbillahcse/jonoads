    <div class="pedigree-grid">
      @foreach (\App\Support\SiteContent::stats('pedigree') as $stat)
      <div class="pedigree-item reveal">
        <x-stat-number :stat="$stat" class="pedigree-number" />
        <span class="pedigree-label">{{ $stat->label }}</span>
      </div>
      @endforeach
    </div>
