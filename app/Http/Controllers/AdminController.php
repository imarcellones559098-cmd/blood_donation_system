<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
{
    $totalDonors = \App\Models\User::where('role', 'donor')->count();
    $totalDonations = \App\Models\Donation::count();
    $pendingDonations = \App\Models\Donation::where('status', 'pending')->count();
    $approvedDonations = \App\Models\Donation::where('status', 'approved')->count();
    $donations = \App\Models\Donation::with('user')->latest()->get();

    return view('admin.dashboard', compact(
        'totalDonors',
        'totalDonations',
        'pendingDonations',
        'approvedDonations',
        'donations'
    ));
}

    public function updateStatus(Request $request, Donation $donation)
    {
        $donation->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated.');
    }

    public function donors()
{
    $donors = \App\Models\User::where('role', 'donor')
                ->with('donorProfile')
                ->latest()
                ->get();

    return view('admin.donors', compact('donors'));
}
}