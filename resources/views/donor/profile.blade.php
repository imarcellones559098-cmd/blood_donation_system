@extends('layouts.donor')

@section('content')
<style>
    * { box-sizing: border-box; }

    .profile-wrapper {
        max-width: 860px;
        margin: 0 auto;
    }

    .profile-header {
        background: linear-gradient(135deg, #7a0000 0%, #cc0000 100%);
        border-radius: 20px;
        padding: 36px 40px;
        display: flex;
        align-items: center;
        gap: 28px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }

    .profile-header::after {
        content: '';
        position: absolute;
        bottom: -60px; right: 60px;
        width: 240px; height: 240px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }

    .profile-avatar {
        width: 80px; height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.4);
        display: flex; align-items: center; justify-content: center;
        font-size: 32px;
        font-weight: 800;
        color: white;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .profile-header-info { position: relative; z-index: 1; }

    .profile-header-info h2 {
        font-size: 24px;
        font-weight: 800;
        color: white;
        margin: 0 0 4px;
    }

    .profile-header-info p {
        font-size: 14px;
        color: rgba(255,255,255,0.65);
        margin: 0 0 10px;
    }

    .blood-type-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 13px;
        font-weight: 700;
        color: white;
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        overflow: hidden;
    }

    .profile-card-header {
        padding: 22px 32px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .profile-card-header h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .profile-card-header p {
        font-size: 13px;
        color: #888;
        margin-top: 2px;
    }

    .edit-badge {
        background: #fff0f0;
        color: #cc0000;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #ffd0d0;
    }

    .profile-form {
        padding: 32px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label .required {
        color: #cc0000;
        font-size: 14px;
    }

    .form-label .icon { font-size: 14px; }

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
    }

    .form-input:focus {
        border-color: #cc0000;
        box-shadow: 0 0 0 3px rgba(204,0,0,0.08);
    }

    .form-input:disabled {
        background: #fafafa;
        color: #999;
        cursor: not-allowed;
        border-color: #f0f0f0;
    }

    .form-input select, select.form-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23888' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }

    textarea.form-input { resize: vertical; min-height: 80px; }

    .form-divider {
        border: none;
        border-top: 1px solid #f0f0f0;
        margin: 8px 0 24px;
    }

    .section-label {
        font-size: 11px;
        font-weight: 700;
        color: #bbb;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #f0f0f0;
    }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 32px;
        background: #fafafa;
        border-top: 1px solid #f0f0f0;
        border-radius: 0 0 20px 20px;
    }

    .form-footer p {
        font-size: 12px;
        color: #aaa;
    }

    .save-btn {
        background: linear-gradient(135deg, #7a0000, #cc0000);
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Segoe UI', sans-serif;
    }

    .save-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(122,0,0,0.35);
    }

    .error-msg {
        font-size: 11px;
        color: #cc0000;
        margin-top: 2px;
    }
</style>

<div class="profile-wrapper">

    {{-- Profile Header Banner --}}
    <div class="profile-header">
        <div class="profile-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div class="profile-header-info">
            <h2>{{ auth()->user()->name }}</h2>
            <p>{{ auth()->user()->email }}</p>
            @if(optional($profile)->blood_type)
                <div class="blood-type-chip">🩸 Blood Type: {{ $profile->blood_type }}</div>
            @else
                <div class="blood-type-chip">🩸 Blood Type: Not set</div>
            @endif
        </div>
    </div>

    {{-- Profile Form Card --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <div>
                <h3>Personal Information</h3>
                <p>Update your donor profile details below</p>
            </div>
            <span class="edit-badge">✏️ Editable</span>
        </div>

        <form action="{{ route('donor.profile.update') }}" method="POST">
            @csrf

            <div class="profile-form">

                {{-- Account Info (read-only) --}}
                <div class="section-label">Account Info</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">👤</span> Full Name
                        </label>
                        <input type="text" class="form-input" value="{{ auth()->user()->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">📧</span> Email Address
                        </label>
                        <input type="email" class="form-input" value="{{ auth()->user()->email }}" disabled>
                    </div>
                </div>

                <hr class="form-divider">

                {{-- Medical Info --}}
                <div class="section-label">Medical Info</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">🩸</span> Blood Type
                            <span class="required">*</span>
                        </label>
                        <select name="blood_type" required class="form-input">
                            <option value="">-- Select Blood Type --</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $type)
                                <option value="{{ $type }}" {{ optional($profile)->blood_type === $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('blood_type')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">⚧</span> Gender
                        </label>
                        <select name="gender" class="form-input">
                            <option value="">-- Select Gender --</option>
                            <option value="Male" {{ optional($profile)->gender === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ optional($profile)->gender === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>

                <hr class="form-divider">

                {{-- Contact Info --}}
                <div class="section-label">Contact & Personal Info</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">📱</span> Contact Number
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="contact_number" required
                               class="form-input"
                               placeholder="e.g. 09123456789"
                               value="{{ optional($profile)->contact_number }}">
                        @error('contact_number')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">🎂</span> Date of Birth
                        </label>
                        <input type="date" name="date_of_birth"
                               class="form-input"
                               value="{{ optional($profile)->date_of_birth }}">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            <span class="icon">📍</span> Address
                        </label>
                        <textarea name="address" class="form-input"
                                  placeholder="Your full address...">{{ optional($profile)->address }}</textarea>
                    </div>
                </div>

            </div>

            <div class="form-footer">
                <p>Fields marked with <strong style="color:#cc0000">*</strong> are required</p>
                <button type="submit" class="save-btn">
                    💾 Save Profile
                </button>
            </div>

        </form>
    </div>

</div>
@endsection