<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    public function index()
    {
        $requests = BloodRequest::with('user')->latest()->get();
        $pending   = $requests->where('status', 'pending')->count();
        $fulfilled = $requests->where('status', 'fulfilled')->count();
        $rejected  = $requests->where('status', 'rejected')->count();

        return view('admin.requests.index', compact('requests', 'pending', 'fulfilled', 'rejected'));
    }

    public function update(Request $request, BloodRequest $bloodRequest)
    {
        $request->validate([
            'status'      => 'required|in:pending,fulfilled,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        if ($bloodRequest->status === 'fulfilled' || $bloodRequest->status === 'rejected') {
            return back()->with('error', 'This request is already ' . $bloodRequest->status . ' and cannot be modified.');
        }

        if ($request->status === 'fulfilled') {
            $inventory = \App\Models\BloodInventory::where('blood_type', $bloodRequest->blood_type)->first();
            
            if (!$inventory || $inventory->units < $bloodRequest->packs_needed) {
                return back()->with('error', "Insufficient {$bloodRequest->blood_type} blood units in inventory. Cannot fulfill request.");
            }
            
            $inventory->decrement('units', $bloodRequest->packs_needed);
        }

        $bloodRequest->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Blood request updated successfully.');
    }
}
