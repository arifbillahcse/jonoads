<form class="enquiry-form" method="POST" action="{{ route('contact.store') }}" novalidate>
  @csrf
  <x-form.spam-fields />
  <input type="hidden" name="source_page" value="{{ request()->path() }}">

  @if (session('contact_status'))
  <p class="form-status is-success" role="status">{{ session('contact_status') }}</p>
  @endif

  <div class="form-row">
    <div class="form-field">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" value="{{ old('name') }}" required
             @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
      @error('name')<span class="form-error" id="name-error">{{ $message }}</span>@enderror
    </div>
    <div class="form-field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required
             @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
      @error('email')<span class="form-error" id="email-error">{{ $message }}</span>@enderror
    </div>
  </div>

  <div class="form-row">
    <div class="form-field">
      <label for="company">Company <span class="form-optional">optional</span></label>
      <input type="text" id="company" name="company" value="{{ old('company') }}">
    </div>
    <div class="form-field">
      <label for="monthly_spend">Monthly media spend <span class="form-optional">optional</span></label>
      <select id="monthly_spend" name="monthly_spend">
        <option value="">Prefer not to say</option>
        @foreach (['Under $10k', '$10k–$50k', '$50k–$250k', '$250k–$1M', 'Over $1M'] as $band)
        <option value="{{ $band }}" @selected(old('monthly_spend') === $band)>{{ $band }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="form-field">
    <label for="message">What are you working on?</label>
    <textarea id="message" name="message" rows="5" required
              @error('message') aria-invalid="true" aria-describedby="message-error" @enderror>{{ old('message') }}</textarea>
    @error('message')<span class="form-error" id="message-error">{{ $message }}</span>@enderror
  </div>

  <button type="submit" class="btn btn-primary btn-large">Send enquiry</button>
</form>
