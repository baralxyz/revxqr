<?php

namespace App\Http\Controllers\Website;

use Exception;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailerController extends Controller
{
    // Compose Email
    public function composeEmail(Request $request)
    {

        if (env('RECAPTCHA_ENABLE') == 'on') {
            $validated = $request->validate([
                'emailName' => 'required',
                'emailRecipient' => 'required',
                'emailBody' => 'required',
                'g-recaptcha-response' => ['recaptcha', 'required']
            ]);
        } else {
            $validated = $request->validate([
                'emailName' => 'required',
                'emailRecipient' => 'required',
                'emailBody' => 'required'
            ]);
        }

        try {
            // Contact Details Array
            $contactDetails = [
                'name' => $request->emailName,
                'email' => $request->emailRecipient,
                'message' => $request->emailBody,
            ];

            // Send mail 
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactMail($contactDetails));

            return redirect()->route('web.contact')->with('success', 'Email sent!');
        } catch (Exception $e) {
            return back()->with("error", "Email service not available.");
        }

        return redirect()->route('web.contact')->with('success', 'Email sent!');
    }
}
