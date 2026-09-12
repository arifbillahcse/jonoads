<x-mail::message>
# New enquiry

**{{ $lead->name }}**{{ $lead->company ? ' — ' . $lead->company : '' }}
{{ $lead->email }}@if ($lead->phone) · {{ $lead->phone }}@endif

@if ($lead->monthly_spend)
**Monthly spend:** {{ $lead->monthly_spend }}
@endif

@if ($lead->source_page)
**Submitted from:** {{ $lead->source_page }}
@endif

---

{{ $lead->message }}

<x-mail::button :url="\App\Filament\Resources\ContactLeads\ContactLeadResource::getUrl()">
Open in the panel
</x-mail::button>

Replying to this email goes straight back to {{ $lead->name }}.
</x-mail::message>
