<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonorProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->donorProfile;
        return view('profile.donor', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'blood_type' => 'required|string',
            'contact_number' => 'required|string',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string',
        ]);

        auth()->user()->donorProfile()->updateOrCreate(
            ['user_id' => auth()->id()],
            $request->only(['blood_type', 'contact_number', 'address', 'date_of_birth', 'gender'])
        );

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}