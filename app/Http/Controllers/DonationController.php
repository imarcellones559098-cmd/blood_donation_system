<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = auth()->user()->donations()->latest()->get();
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        return view('donations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'packs' => 'required|integer|min:1',
            'donation_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        auth()->user()->donations()->create($request->all());

        return redirect()->route('donations.index')->with('success', 'Donation recorded successfully!');
    }

    public function edit(Donation $donation)
    {
        abort_if($donation->user_id !== auth()->id(), 403);
        return view('donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        abort_if($donation->user_id !== auth()->id(), 403);

        $request->validate([
            'packs' => 'required|integer|min:1',
            'donation_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $donation->update($request->all());

        return redirect()->route('donations.index')->with('success', 'Donation updated successfully!');
    }

    public function destroy(Donation $donation)
    {
        abort_if($donation->user_id !== auth()->id(), 403);
        $donation->delete();
        return redirect()->route('donations.index')->with('success', 'Donation deleted.');
    }
}