<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // E-mail adatainak validálása
        $validated = $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // E-mail küldése
        try {
            Mail::to($validated['to'])->send(new SignupMail($validated['subject'], $validated['message']));

            return response()->json(['status' => 'success', 'message' => 'E-mail sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
