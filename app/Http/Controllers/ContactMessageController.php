<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display contact messages (Admin only)
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Show contact message details
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read
        if ($contactMessage->status === 'Unread') {
            $contactMessage->update(['status' => 'Read']);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Store a new contact message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:191',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return redirect()->back()
            ->with('success', 'Your message has been sent successfully. We will get back to you soon.');
    }

    /**
     * Delete a contact message
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    /**
     * Mark message as read (API)
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->update(['status' => 'Read']);

        return response()->json(['success' => true]);
    }
}
