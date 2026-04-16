@extends('layouts.donor')

@section('content')
<div class="max-w-xl mx-auto">
    <h2 class="text-2xl font-bold text-red-700 mb-6">Add New Donation</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('donor.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Donation Date <span class="text-red-500">*</span>
                </label>
                <input type="date" name="donation_date" required
                       value="{{ old('donation_date') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                @error('donation_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Number of Packs <span class="text-red-500">*</span>
                </label>
                <input type="number" name="packs" min="1" required
                       value="{{ old('packs') }}"
                       placeholder="e.g. 1"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                @error('packs')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Notes (optional)</label>
                <textarea name="notes" rows="3"
                          placeholder="Any additional information..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">{{ old('notes') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-red-700 text-white px-6 py-2 rounded-lg hover:bg-red-800 font-semibold">
                    Submit Donation
                </button>
                <a href="{{ route('donor.dashboard') }}"
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection