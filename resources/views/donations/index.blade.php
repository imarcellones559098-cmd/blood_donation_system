<x-app-layout>
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-red-700">My Donations</h1>
        <a href="{{ route('donations.create') }}" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">
            + Add Donation
        </a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-red-700 text-white">
                <tr>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Packs</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Notes</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                <tr class="border-b">
                    <td class="p-3">{{ $donation->donation_date }}</td>
                    <td class="p-3">{{ $donation->packs }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs
                            {{ $donation->status === 'approved' ? 'bg-green-100 text-green-700' :
                               ($donation->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $donation->notes ?? '—' }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('donations.edit', $donation) }}"
                           class="text-blue-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('donations.destroy', $donation) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline"
                                    onclick="return confirm('Delete this donation?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-4 text-center text-gray-400">No donations yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>