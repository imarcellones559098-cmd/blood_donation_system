<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\DonorProfile;

class DonorController extends Controller
{
    public function dashboard()
{
    $donations = auth()->user()->donations()->latest()->get();
    $profile   = auth()->user()->donorProfile; // adjust to your actual relationship name

    return view('donor.dashboard', compact('donations', 'profile'));
}

    public function create()
    {
        return view('donor.donate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'packs' => 'required|integer|min:1',
            'donation_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Donation::create([
            'user_id' => auth()->id(),
            'packs' => $request->packs,
            'donation_date' => $request->donation_date,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('donor.dashboard')->with('success', 'Donation submitted successfully!');
    }

    public function edit(Donation $donation)
    {
        if ($donation->user_id !== auth()->id()) abort(403);
        return view('donor.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        if ($donation->user_id !== auth()->id()) abort(403);

        $request->validate([
            'packs' => 'required|integer|min:1',
            'donation_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $donation->update($request->only('packs', 'donation_date', 'notes'));
        return redirect()->route('donor.dashboard')->with('success', 'Donation updated successfully!');
    }

    public function destroy(Donation $donation)
    {
        if ($donation->user_id !== auth()->id()) abort(403);
        $donation->delete();
        return redirect()->route('donor.dashboard')->with('success', 'Donation deleted successfully!');
    }

    public function profile()
    {
        $profile = auth()->user()->donorProfile;
        return view('donor.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'blood_type' => 'required|string',
            'contact_number' => 'required|string',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
        ]);

        DonorProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $request->only('blood_type', 'contact_number', 'address', 'date_of_birth', 'gender')
        );

        return redirect()->route('donor.profile')->with('success', 'Profile updated successfully!');
    }
}