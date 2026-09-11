{{--
    Hidden from people, tempting to bots. `tabindex="-1"` and `autocomplete="off"`
    keep it out of the way of anyone tabbing or autofilling; it is hidden with a
    class rather than `type="hidden"` so naive bots still see a fillable field.
--}}
<div class="form-trap" aria-hidden="true">
  <label for="{{ \App\Support\SpamGuard::HONEYPOT }}">Leave this field empty</label>
  <input type="text"
         id="{{ \App\Support\SpamGuard::HONEYPOT }}"
         name="{{ \App\Support\SpamGuard::HONEYPOT }}"
         value=""
         tabindex="-1"
         autocomplete="off">
</div>
<input type="hidden" name="{{ \App\Support\SpamGuard::TIMESTAMP }}" value="{{ \App\Support\SpamGuard::timestamp() }}">
