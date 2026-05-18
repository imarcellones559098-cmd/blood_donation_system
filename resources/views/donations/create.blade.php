@extends('layouts.admin')

@section('content')
<style>
    .form-wrapper {
        max-width: 640px;
        margin: 0 auto;
        padding: 32px 20px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 4px;
    }
    .page-sub {
        font-size: 13px;
        color: #aaa;
        margin-bottom: 28px;
    }
    .form-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        overflow: hidden;
    }
    .form-card-header {
        background: linear-gradient(90deg, #7a0000, #cc0000);
        padding: 20px 28px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-card-header h3 {
        font-size: 15px;
        font-weight: 700;
        color: white;
        margin: 0;
    }
    .form-body {
        padding: 28px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 7px;
    }
    .required { color: #cc0000; }
    .form-input {
        width: 100%;
        border: 1.5px solid #e8e8e8;
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 14px;
        color: #1a1a1a;
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        font-family: 'Segoe UI', sans-serif;
        box-sizing: border-box;
    }
    .form-input:focus {
        border-color: #cc0000;
        box-shadow: 0 0 0 3px rgba(204,0,0,0.08);
    }
    select.form-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23888' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }
    textarea.form-input {
        resize: vertical;
        min-height: 80px;
    }
    .error-msg {
        font-size: 11px;
        color: #cc0000;
        margin-top: 4px;
    }
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 28px;
        background: #fafafa;
        border-top: 1px solid #f0f0f0;
    }
    .btn-cancel {
        padding: 10px 22px;
        background: white;
        color: #888;
        border: 1.5px solid #e8e8e8;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        font-family: 'Segoe UI', sans-serif;
    }
    .btn-cancel:hover { background: #f5f5f5; color: #555; }
    .btn-save {
        background: linear-gradient(135deg, #7a0000, #cc0000);
        color: white;
        border: none;
        padding: 11px 28px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        font-family: 'Segoe UI', sans-serif;
    }
    .btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(122,0,0,0.3);
    }
    .auto-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0fff4;
        border: 1px solid #bbf7d0;
        color: #16a34a;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        margin-bottom: 20px;
    }
</style>

<div class="form-wrapper">
    <div class="page-title">Record Blood Donation</div>
    <div class="page-sub">Admin-recorded donations are automatically approved</div>

    <div class="form-card">
        <div class="form-card-header">
            <span style="font-size:18px;">🩸</span>
            <h3>New Donation Entry</h3>
        </div>

        <form action="{{ route('admin.donations.store') }}" method="POST">
            @csrf
            <div class="form-body">

                <div class="auto-badge">
                    ✅ Status will be set to <strong>Approved</strong> automatically
                </div>

                {{-- Select Donor --}}
                <div class="form-group">
                    <label class="form-label">
                        👤 Select Donor <span class="required">*</span>
                    </label>
                    <select name="user_id" required class="form-input">
                        <option value="">-- Choose a donor --</option>
                        @foreach($donors as $donor)
                            <option value="{{ $donor->id }}" {{ old('user_id') == $donor->id ? 'selected' : '' }}>
                                {{ $donor->name }} ({{ $donor->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Donation Date --}}
                <div class="form-group">
                    <label class="form-label">
                        📅 Donation Date <span class="required">*</span>
                    </label>
                    <input type="date" name="donation_date" required
                           class="form-input"
                           value="{{ old('donation_date', now()->format('Y-m-d')) }}">
                    @error('donation_date')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Number of Packs --}}
                <div class="form-group">
                    <label class="form-label">
                        🩸 Number of Packs <span class="required">*</span>
                    </label>
                    <input type="number" name="packs" required
                           class="form-input"
                           min="1"
                           placeholder="e.g. 1"
                           value="{{ old('packs') }}">
                    @error('packs')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="form-group">
                    <label class="form-label">📝 Notes (optional)</label>
                    <textarea name="notes" class="form-input"
                              placeholder="Any additional information...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="form-footer">
                <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">
                    💾 Record Donation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection