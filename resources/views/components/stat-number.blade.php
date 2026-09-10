@props(['stat', 'class' => 'stat-number'])
{{--
    The counter animates from zero, so the target ships as data attributes and
    the element's own text is only what shows before the JS runs (or if it never
    does). A stat flagged static prints its value and the JS skips it.

    Empty attributes are omitted: the counter reads `dataset.prefix || ''`, so an
    absent attribute and an empty one behave identically.
--}}
@if ($stat->is_static)
{{-- One styled class for static figures, whichever strip they sit in. --}}
<span class="stat-number-static">{{ $stat->static_value }}</span>
@else
<span class="{{ $class }}" data-target="{{ $stat->animationTarget() }}"@if (filled($stat->prefix)) data-prefix="{{ $stat->prefix }}"@endif @if (filled($stat->suffix)) data-suffix="{{ $stat->suffix }}"@endif @if ($stat->decimals > 0) data-decimals="{{ $stat->decimals }}"@endif>{{ $stat->zeroState() }}</span>
@endif
