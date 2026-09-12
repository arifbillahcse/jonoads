<x-mail::message>
# One more step

Confirm your address and we'll send you what's working on Meta, Google and CTV
each month — straight from the people running the accounts.

<x-mail::button :url="$confirmUrl">
Confirm subscription
</x-mail::button>

If you didn't sign up, ignore this email and nothing else will arrive.

Thanks,<br>
{{ config('app.name') }}

<x-slot:subcopy>
Changed your mind? [Unsubscribe]({{ $subscriber->unsubscribeUrl() }}).
</x-slot:subcopy>
</x-mail::message>
