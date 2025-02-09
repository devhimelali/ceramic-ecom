<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsAcknowledgmentMail;
use App\Http\Requests\Frontend\ContactUs\StoreRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(StoreRequest $request)
    {
        $contact = ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        Mail::to($contact->email)->send(new ContactUsAcknowledgmentMail($contact));

        return redirect()->back()->with('success', 'Message sent successfully');
    }
}
