<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Mail\ContactReplyMail;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::orderBy('id', 'desc');
            return DataTables(source: $data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('contacts.destroy', $row->id);
                    return '
                        <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-secondary viewDetails" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#modal"><i class="bi bi-eye me-2"></i>View</button>
                        <button type="button" class="btn btn-sm btn-warning replyBtn" data-id="' . $row->id . '" data-bs-toggle="modal" data-bs-target="#contactReplyModal"><i class="bi bi-envelope me-2"></i>Reply</button>
                            <a href="javascript:void(0);" onclick="deleteContact(\'' . $deleteUrl . '\')" class="btn btn-sm btn-danger delete-item-btn">
                                <i class="bi bi-trash me-2"></i>Delete
                            </a>
                        </div>
                    ';
                })
                ->make(true);
        }

        $data = [
            'active' => 'contacts'
        ];

        return view('admin.contact.index', $data);
    }

    public function show($id)
    {
        $contact = ContactUs::find($id);

        if (!$contact) {
            return redirect()->route('contacts.index')->with('error', 'Contact not found');
        }

        $contact->update([
            'is_read' => 1
        ]);

        return view('admin.contact.show', compact('contact'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => ['required', 'string'],
        ]);

        $contact = ContactUs::find($id);

        $contact->update([
            'is_replied' => 1,
            'reply_message' => $request->reply_message,
            'replied_at' => now(),
        ]);

        Mail::to($contact->email)->send(new ContactReplyMail($contact, $request->reply_message));

        return response()->json([
            'status' => 'success',
            'message' => 'Reply sent successfully',
        ]);
    }
}
