@extends('layouts.donor')

@section('content')
<div style="max-width: 600px; margin: 40px auto 0;">
    <div class="section-header" style="margin-bottom: 24px;">
        <div>
            <div class="section-title">Submit Blood Request</div>
            <div class="section-sub">Fill in the details below to request blood for yourself or someone else</div>
        </div>
    </div>

    <div class="table-card" style="padding: 32px;">
        <form method="POST" action="{{ route('donor.requests.store') }}">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Blood Type <span style="color:#cc0000">*</span></label>
                    <select name="blood_type" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; background-color: white;">
                        <option value="">-- Select --</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                            <option value="{{ $type }}" {{ old('blood_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('blood_type') <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Packs Needed <span style="color:#cc0000">*</span></label>
                    <input type="number" name="packs_needed" min="1" value="{{ old('packs_needed') }}" placeholder="e.g. 2" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif;">
                    @error('packs_needed') <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="margin-bottom: 32px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Reason for Request <span style="color:#cc0000">*</span></label>
                <textarea name="reason" rows="4" placeholder="Briefly explain why you need blood..." class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; resize: vertical;">{{ old('reason') }}</textarea>
                @error('reason') <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 12px; align-items: center; padding-top: 24px; border-top: 1px solid #f1f5f9;">
                <button type="submit" style="background: linear-gradient(135deg, #7a0000, #cc0000); color: white; border: none; padding: 12px 32px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(204,0,0,0.2); font-family: 'Inter', sans-serif;">
                    ✔ Submit Request
                </button>
                <a href="{{ route('donor.requests.index') }}" style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600; padding: 12px 24px; border-radius: 12px; transition: all 0.2s; border: 1px solid transparent; background: #f8f9fb; text-align: center;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .search-input:focus { border-color: #cc0000 !important; box-shadow: 0 0 0 3px rgba(204,0,0,0.1) !important; outline: none; }
    button[type="submit"]:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(204,0,0,0.3) !important; }
    a[href]:hover { background: #f1f5f9 !important; border-color: #e2e8f0 !important; color: #334155 !important; }
</style>
@endsection
