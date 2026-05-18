@extends('layouts.admin')

@section('content')
<style>
    .blood-pill { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: #fff0f0; color: #cc0000; font-size: 12px; font-weight: 800; box-shadow: 0 2px 5px rgba(204,0,0,0.1); }
    .blood-empty { background: #f5f5f5; color: #bbb; font-size: 11px; width: auto; padding: 0 10px; border-radius: 20px; height: 26px; box-shadow: none; font-weight: 600; }
    .gender-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .gender-m { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .gender-f { background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8; }
    .gender-u { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .status-pill { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .status-complete { background: #f0fff4; color: #16a34a; border: 1px solid #bbf7d0; }
    .status-partial { background: #fffbf0; color: #ca8a04; border: 1px solid #fef08a; }
    .status-incomplete { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .filter-select { padding: 10px 14px; border: 1px solid #e5e7eb; border-radius: 12px; font-size: 13px; color: #334155; background: white; outline: none; cursor: pointer; font-family: inherit; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
    .filter-select:focus { border-color: #cc0000; box-shadow: 0 0 0 3px rgba(204,0,0,0.1); }
    .count-badge { background: #fff0f0; color: #cc0000; font-size: 13px; font-weight: 700; padding: 8px 16px; border-radius: 20px; margin-left: auto; }
</style>

<!-- Top Bar -->
<div class="topbar">
    <div class="topbar-title">
        <h1>Donor Management</h1>
        <p>View and manage all registered donors</p>
    </div>
    <div class="topbar-right">
        <span class="date-badge">📅 {{ now()->format('F d, Y') }}</span>
    </div>
</div>

@if(session('success'))
<div class="alert-success">✅ {{ session('success') }}</div>
@endif

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon red">👥</div>
        <div class="stat-info">
            <div class="stat-value">{{ $donors->count() }}</div>
            <div class="stat-label">Total Donors</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">🩸</div>
        <div class="stat-info">
            <div class="stat-value">{{ $donors->filter(fn($d) => $d->donorProfile && $d->donorProfile->blood_type)->pluck('donorProfile.blood_type')->unique()->count() }}</div>
            <div class="stat-label">Blood Types</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div class="stat-info">
            <div class="stat-value">{{ $donors->filter(fn($d) => $d->donorProfile && $d->donorProfile->blood_type && $d->donorProfile->contact_number && $d->donorProfile->gender)->count() }}</div>
            <div class="stat-label">Complete Profiles</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">⚠️</div>
        <div class="stat-info">
            <div class="stat-value">{{ $donors->filter(fn($d) => !$d->donorProfile || !$d->donorProfile->blood_type || !$d->donorProfile->contact_number)->count() }}</div>
            <div class="stat-label">Incomplete</div>
        </div>
    </div>
</div>

<!-- Toolbar -->
<div class="section-header" style="align-items: flex-end; margin-bottom: 24px;">
    <div>
        <div class="section-title">Donor Registry</div>
        <div class="section-sub">All registered blood donors</div>
    </div>
    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <input type="text" id="searchInput" class="search-input" placeholder="Search donors..." oninput="filterRows()">
        <select class="filter-select" id="bloodFilter" onchange="filterRows()">
            <option value="">All blood types</option>
            @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bt)
                <option value="{{ $bt }}">{{ $bt }}</option>
            @endforeach
        </select>
        <select class="filter-select" id="genderFilter" onchange="filterRows()">
            <option value="">All genders</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <span class="count-badge" id="countBadge">{{ $donors->count() }} donors</span>
    </div>
</div>

<!-- Table -->
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Donor</th>
                <th>Email</th>
                <th>Blood Type</th>
                <th>Contact</th>
                <th>Gender</th>
                <th>Profile Status</th>
            </tr>
        </thead>
        <tbody id="donorTable">
            @forelse($donors as $i => $donor)
            @php
                $profile = $donor->donorProfile;
                $blood = $profile->blood_type ?? null;
                $contact = $profile->contact_number ?? null;
                $gender = $profile->gender ?? null;
                $missing = collect([$blood, $contact, $gender])->filter()->count();
                if ($missing === 3) { $statusLabel = 'Complete'; $statusClass = 'status-complete'; $dotColor = '#16a34a'; }
                elseif ($missing >= 1) { $statusLabel = 'Partial'; $statusClass = 'status-partial'; $dotColor = '#ca8a04'; }
                else { $statusLabel = 'Incomplete'; $statusClass = 'status-incomplete'; $dotColor = '#dc2626'; }
                $initials = strtoupper(substr($donor->name, 0, 1)) . (str_contains($donor->name, ' ') ? strtoupper(substr(explode(' ', $donor->name)[1], 0, 1)) : '');
                $genderClass = $gender === 'Male' ? 'gender-m' : ($gender === 'Female' ? 'gender-f' : 'gender-u');
            @endphp
            <tr
                data-name="{{ strtolower($donor->name) }}"
                data-email="{{ strtolower($donor->email) }}"
                data-blood="{{ $blood ?? '' }}"
                data-gender="{{ $gender ?? '' }}"
            >
                <td>
                    <div class="donor-cell">
                        <div class="donor-avatar">{{ $initials }}</div>
                        <div>
                            <div class="donor-name">{{ $donor->name }}</div>
                            <div style="font-size:11px; color:#94a3b8; margin-top:2px; font-weight:600; letter-spacing:0.5px;">D-{{ str_pad($donor->id, 3, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:#475569; font-size:13px; font-weight:500;">{{ $donor->email }}</td>
                <td>
                    @if($blood)
                        <span class="blood-pill">{{ $blood }}</span>
                    @else
                        <span class="blood-pill blood-empty">—</span>
                    @endif
                </td>
                <td style="color:#475569; font-size:13px; font-weight:500;">{{ $contact ?? '—' }}</td>
                <td>
                    <span class="gender-badge {{ $genderClass }}">{{ $gender ?? '—' }}</span>
                </td>
                <td>
                    <span class="status-pill {{ $statusClass }}">
                        <span class="dot" style="background:{{ $dotColor }}"></span>
                        {{ $statusLabel }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="icon">🩸</div>
                        <p>No donors registered yet.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function filterRows() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const bf = document.getElementById('bloodFilter').value;
    const gf = document.getElementById('genderFilter').value;
    const rows = document.querySelectorAll('#donorTable tr[data-name]');
    let visible = 0;
    rows.forEach(row => {
        const matchQ = !q || row.dataset.name.includes(q) || row.dataset.email.includes(q);
        const matchB = !bf || row.dataset.blood === bf;
        const matchG = !gf || row.dataset.gender === gf;
        const show = matchQ && matchB && matchG;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('countBadge').textContent = visible + ' donor' + (visible !== 1 ? 's' : '');
}
</script>
@endsection