@extends('layouts.admin')

@section('content')
<div style="max-width: 600px; margin: 40px auto 0;">
    <div class="section-header" style="margin-bottom: 24px;">
        <div>
            <div class="section-title">Record Donation</div>
            <div class="section-sub">Manually log a blood donation from a registered donor</div>
        </div>
    </div>

    <div class="table-card" style="padding: 32px;">
        <form method="POST" action="{{ route('admin.donations.store') }}">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Select Donor <span style="color:#cc0000">*</span></label>
                <select name="user_id" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; background-color: white;">
                    <option value="">-- Choose Donor --</option>
                    @foreach($donors as $donor)
                        <option value="{{ $donor->id }}">{{ $donor->name }} ({{ $donor->email }})</option>
                    @endforeach
                </select>
                @error('user_id') <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Donation Date <span style="color:#cc0000">*</span></label>
                    <input type="date" name="donation_date" value="{{ old('donation_date', date('Y-m-d')) }}" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif;">
                    @error('donation_date') <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Packs Donated <span style="color:#cc0000">*</span></label>
                    <input type="number" name="packs" min="1" value="{{ old('packs') }}" placeholder="e.g., 1" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif;">
                    @error('packs') <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Initial Status <span style="color:#cc0000">*</span></label>
                <select name="status" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; background-color: white;">
                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending (Needs Approval Later)</option>
                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved (Instantly Fulfills)</option>
                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status') <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom: 32px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Additional Notes</label>
                <textarea name="notes" rows="4" placeholder="Any medical observations or remarks..." class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; resize: vertical;">{{ old('notes') }}</textarea>
                @error('notes') <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 12px; align-items: center; padding-top: 24px; border-top: 1px solid #f1f5f9;">
                <button type="submit" style="background: linear-gradient(135deg, #7a0000, #cc0000); color: white; border: none; padding: 12px 32px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(204,0,0,0.2); font-family: 'Inter', sans-serif;">
                    ✔ Save Donation
                </button>
                <a href="{{ route('admin.dashboard') }}" style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600; padding: 12px 24px; border-radius: 12px; transition: all 0.2s; border: 1px solid transparent; background: #f8f9fb; text-align: center;">
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