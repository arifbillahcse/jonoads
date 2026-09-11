<form class="newsletter-form" method="POST" action="{{ route('newsletter.subscribe') }}">
  @csrf
  <x-form.spam-fields />
  <input type="hidden" name="source_page" value="{{ request()->path() }}">
  <input type="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" required aria-label="Email address">
  <button type="submit" class="btn btn-primary">Subscribe</button>
</form>
@if (session('newsletter_status'))
<p class="newsletter-success is-visible" role="status">{{ session('newsletter_status') }}</p>
@elseif ($errors->has('email'))
<p class="newsletter-success is-visible is-error" role="alert">{{ $errors->first('email') }}</p>
@endif
