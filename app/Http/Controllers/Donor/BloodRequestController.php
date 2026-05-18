<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    public function index()
    {
        $requests = BloodRequest::where('user_id', auth()->id())
                        ->latest()
                        ->get();
        return view('donor.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('donor.requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'blood_type'   => 'required|string',
            'packs_needed' => 'required|integer|min:1',
            'reason'       => 'required|string|max:500',
        ]);

        BloodRequest::create([
            'user_id'      => auth()->id(),
            'blood_type'   => $request->blood_type,
            'packs_needed' => $request->packs_needed,
            'reason'       => $request->reason,
            'status'       => 'pending',
        ]);

        return redirect()->route('donor.requests.index')
                         ->with('success', 'Blood request submitted successfully!');
    }

    public function destroy(BloodRequest $bloodRequest)
    {
        if ($bloodRequest->user_id !== auth()->id()) {
            abort(403);
        }
        if ($bloodRequest->status !== 'pending') {
            return back()->with('error', 'Cannot delete a processed request.');
        }
        $bloodRequest->delete();
        return back()->with('success', 'Request deleted.');
    }
}
