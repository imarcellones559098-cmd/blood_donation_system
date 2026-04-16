<x-app-layout>
    <h1 class="text-2xl font-bold text-red-700 mb-2">Welcome, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-500 mb-6">Here's a summary of your donations.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded shadow p-4 text-center">
            <p class="text-gray-500">Total Donations</p>
            <p class="text-3xl font-bold text-red-700">{{ auth()->user()->donations()->count() }}</p>
        </div>
        <div class="bg-white rounded shadow p-4 text-center">
            <p class="text-gray-500">Pending</p>
            <p class="text-3xl font-bold text-yellow-500">{{ auth()->user()->donations()->where('status','pending')->count() }}</p>
        </div>
        <div class="bg-white rounded shadow p-4 text-center">
            <p class="text-gray-500">Approved</p>
            <p class="text-3xl font-bold text-green-600">{{ auth()->user()->donations()->where('status','approved')->count() }}</p>
        </div>
    </div>

    @php $profile = auth()->user()->donorProfile; @endphp

    @if(!$profile)
        <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded p-4 mb-6">
            ⚠️ Please complete your <a href="{{ route('donor.profile.edit') }}" class="underline font-bold">Donor Profile</a> to get started.
        </div>
    @else
        <div class="bg-white rounded shadow p-6 mb-6">
            <h2 class="text-lg font-bold text-red-700 mb-4">My Profile</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><span class="font-medium text-gray-500">Name:</span> {{ auth()->user()->name }}</div>
                <div><span class="font-medium text-gray-500">Email:</span> {{ auth()->user()->email }}</div>
                <div><span class="font-medium text-gray-500">Blood Type:</span>
                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded font-bold">{{ $profile->blood_type }}</span>
                </div>
                <div><span class="font-medium text-gray-500">Contact:</span> {{ $profile->contact_number }}</div>
                <div><span class="font-medium text-gray-500">Gender:</span> {{ $profile->gender ?? '—' }}</div>
                <div><span class="font-medium text-gray-500">Date of Birth:</span> {{ $profile->date_of_birth ?? '—' }}</div>
                <div class="md:col-span-2"><span class="font-medium text-gray-500">Address:</span> {{ $profile->address ?? '—' }}</div>
            </div>
            <div class="mt-4">
                <a href="{{ route('donor.profile.edit') }}" class="text-red-700 underline text-sm">✏️ Edit Profile</a>
            </div>
        </div>
    @endif

    <div class="flex justify-between items-center mb-3">
        <h2 class="text-lg font-bold text-red-700">My Donations</h2>
        <a href="{{ route('donations.create') }}" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800 text-sm">
            + Add Donation
        </a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-red-700 text-white">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Packs</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Notes</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse(auth()->user()->donations()->latest()->get() as $i => $donation)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $i + 1 }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($donation->donation_date)->format('M d, Y') }}</td>
                    <td class="p-3">{{ $donation->packs }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            {{ $donation->status === 'approved' ? 'bg-green-100 text-green-700' :
                               ($donation->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $donation->notes ?? '—' }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('donations.edit', $donation) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('donations.destroy', $donation) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline"
                                    onclick="return confirm('Delete this donation?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-4 text-center text-gray-400">No donations yet. Click "+ Add Donation" to start.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>