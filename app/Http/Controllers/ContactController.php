<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactLeadRequest;
use App\Mail\ContactLeadReceived;
use App\Models\ContactLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactLeadRequest $request): RedirectResponse
    {
        $lead = ContactLead::create([
            ...$request->safe()->only(['name', 'email', 'company', 'phone', 'monthly_spend', 'message']),
            'status' => 'new',
            'source_page' => $request->input('source_page') ?: url()->previous(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // The enquiry is already saved, so a mail outage must not lose it or
        // show the sender an error. Queued where a worker is running; failures
        // are logged and the lead still shows up in the panel.
        try {
            Mail::to(config('mail.contact_address'))->send(new ContactLeadReceived($lead));
        } catch (\Throwable $e) {
            Log::error('Contact enquiry saved but notification failed', [
                'lead_id' => $lead->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('contact')
            ->with('contact_status', "Thanks — we'll come back to you shortly.")
            ->withFragment('enquiry');
    }
}
