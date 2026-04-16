<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded shadow overflow-hidden">

            {{-- Header --}}
            <div class="bg-red-700 text-white px-6 py-4">
                <h1 class="text-xl font-bold">🩸 Donor Profile</h1>
                <p class="text-red-200 text-sm">Fill in your details to complete your donor registration.</p>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('donor.profile.update') }}">
                    @csrf

                    {{-- Personal Info --}}
                    <h2 class="text-md font-bold text-gray-700 mb-3 border-b pb-1">Personal Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" disabled
                                   class="w-full border rounded p-2 bg-gray-100 text-gray-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                            <input type="text" value="{{ auth()->user()->email }}" disabled
                                   class="w-full border rounded p-2 bg-gray-100 text-gray-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                   value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}"
                                   class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Gender</label>
                            <select name="gender" class="w-full border rounded p-2">
                                <option value="">-- Select --</option>
                                <option value="Male" {{ old('gender', $profile->gender ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $profile->gender ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>

                    {{-- Contact Info --}}
                    <h2 class="text-md font-bold text-gray-700 mb-3 border-b pb-1">Contact Details</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Contact Number</label>
                            <input type="text" name="contact_number"
                                   value="{{ old('contact_number', $profile->contact_number ?? '') }}"
                                   placeholder="e.g. 09123456789"
                                   class="w-full border rounded p-2 @error('contact_number') border-red-500 @enderror">
                            @error('contact_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Blood Type</label>
                            <select name="blood_type" class="w-full border rounded p-2">
                                <option value="">-- Select --</option>
                                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                                    <option value="{{ $type }}" {{ old('blood_type', $profile->blood_type ?? '') === $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('blood_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                            <input type="text" name="address"
                                   value="{{ old('address', $profile->address ?? '') }}"
                                   placeholder="e.g. Purok 2, Barangay San Nicolas, Cebu City"
                                   class="w-full border rounded p-2">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 mt-4">
                        <button type="submit" class="bg-red-700 text-white px-6 py-2 rounded hover:bg-red-800 font-medium">
                            💾 Save Profile
                        </button>
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:underline text-sm">← Back to Dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>