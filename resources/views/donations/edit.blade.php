<x-app-layout>
    <h1 class="text-2xl font-bold text-red-700 mb-4">Edit Donation</h1>

    <div class="bg-white rounded shadow p-6 max-w-lg">
        <form method="POST" action="{{ route('donations.update', $donation) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Donation Date</label>
                <input type="date" name="donation_date" value="{{ old('donation_date', $donation->donation_date) }}"
                       class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Number of Packs</label>
                <input type="number" name="packs" value="{{ old('packs', $donation->packs) }}" min="1"
                       class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Notes (optional)</label>
                <textarea name="notes" rows="3" class="w-full border rounded p-2">{{ old('notes', $donation->notes) }}</textarea>
            </div>

            <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">
                Update
            </button>
            <a href="{{ route('donations.index') }}" class="ml-2 text-gray-500 hover:underline">Cancel</a>
        </form>
    </div>
</x-app-layout>