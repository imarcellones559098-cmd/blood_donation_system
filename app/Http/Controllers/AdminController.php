<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalDonors    = User::where('role', 'donor')->count();
        $totalDonations = Donation::count();
        $pending        = Donation::where('status', 'pending')->count();
        $approved       = Donation::where('status', 'approved')->count();
        $recentDonations = Donation::with('user')->latest()->get();
        $donations = Donation::with('user')->latest()->get();
        return view('admin.dashboard', compact(
            'totalDonors','totalDonations','pending','approved','recentDonations','donations'
        ));
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);

        if ($donation->status === 'approved' || $donation->status === 'rejected') {
            return back()->with('error', 'This donation is already ' . $donation->status . ' and cannot be modified.');
        }

        $donation->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            $user = $donation->user;
            $donorProfile = $user->donorProfile;
            if ($donorProfile && $donorProfile->blood_type) {
                $inventory = \App\Models\BloodInventory::firstOrCreate(
                    ['blood_type' => $donorProfile->blood_type],
                    ['units' => 0]
                );
                $inventory->increment('units', $donation->packs);
            }
        }

        return back()->with('success', 'Donation status updated successfully.');
    }

    // NEW: Show form to record donation for a donor
    public function createDonation()
    {
        $donors = User::where('role', 'donor')->get();
        return view('admin.donations.create', compact('donors'));
    }

    // NEW: Store the donation
    public function storeDonation(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'donation_date' => 'required|date',
            'packs'         => 'required|integer|min:1',
            'status'        => 'required|in:pending,approved,rejected',
            'notes'         => 'nullable|string|max:500',
        ]);

        $donation = Donation::create([
            'user_id'       => $request->user_id,
            'donation_date' => $request->donation_date,
            'packs'         => $request->packs,
            'notes'         => $request->notes,
            'status'        => $request->status,
        ]);

        if ($donation->status === 'approved') {
            $user = $donation->user;
            $donorProfile = $user->donorProfile;
            if ($donorProfile && $donorProfile->blood_type) {
                $inventory = \App\Models\BloodInventory::firstOrCreate(
                    ['blood_type' => $donorProfile->blood_type],
                    ['units' => 0]
                );
                $inventory->increment('units', $donation->packs);
            }
        }

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Donation recorded successfully!');
    }
    public function donors()
    {
        $donors = User::where('role', 'donor')->get();
        return view('admin.donors', compact('donors'));
    }
    public function requests()
    {
        $requests  = \App\Models\BloodRequest::with('user')->latest()->get();
        $pending   = $requests->where('status', 'pending')->count();
        $fulfilled = $requests->where('status', 'fulfilled')->count();
        $rejected  = $requests->where('status', 'rejected')->count();

        return view('admin.requests.index', compact('requests', 'pending', 'fulfilled', 'rejected'));
    }
}
