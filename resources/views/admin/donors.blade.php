<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donors — Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fb; min-height: 100vh; display: flex; }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px; min-height: 100vh;
            background: #7a0000;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; z-index: 100;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }
        .sidebar-brand { padding: 28px 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .logo { font-size: 20px; font-weight: 800; color: white; letter-spacing: -0.5px; display: flex; align-items: center; gap: 10px; }
        .logo-icon { width: 36px; height: 36px; background: rgba(255,255,255,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .sidebar-brand p { font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 4px; padding-left: 46px; }
        .sidebar-nav { flex: 1; padding: 16px 0; }
        .nav-label { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.35); letter-spacing: 1.2px; text-transform: uppercase; padding: 12px 24px 6px; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 11px 24px; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; border-left: 3px solid transparent; margin: 1px 0; }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .nav-item.active { background: rgba(255,255,255,0.12); color: white; border-left-color: #ff6666; font-weight: 600; }
        .nav-item .icon { width: 20px; text-align: center; font-size: 16px; }
        .sidebar-footer { padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.1); }
        .admin-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .admin-avatar { width: 36px; height: 36px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; color: white; font-weight: 700; }
        .admin-name { font-size: 13px; font-weight: 600; color: white; }
        .admin-role { font-size: 11px; color: rgba(255,255,255,0.45); }
        .logout-btn { width: 100%; padding: 9px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: rgba(255,255,255,0.7); font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .logout-btn:hover { background: rgba(255,255,255,0.15); color: white; }

        /* ── Main ── */
        .main { margin-left: 240px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── Topbar ── */
        .topbar { background: white; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 50; }
        .topbar-title h1 { font-size: 20px; font-weight: 700; color: #1a1a1a; }
        .topbar-title p { font-size: 13px; color: #888; margin-top: 2px; }
        .date-badge { font-size: 13px; color: #666; background: #f4f4f4; padding: 6px 14px; border-radius: 20px; }

        /* ── Content ── */
        .content { padding: 32px; flex: 1; }

        /* ── Stat cards ── */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
        .stat-card { background: white; border-radius: 16px; padding: 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 16px; transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
        .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
        .stat-icon.red { background: #fff0f0; }
        .stat-icon.blue { background: #f0f4ff; }
        .stat-icon.yellow { background: #fffbf0; }
        .stat-icon.green { background: #f0fff4; }
        .stat-value { font-size: 28px; font-weight: 800; color: #1a1a1a; line-height: 1; }
        .stat-label { font-size: 13px; color: #888; margin-top: 4px; }
        .stat-tag { font-size: 11px; margin-top: 6px; display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 20px; font-weight: 600; }
        .tag-red { background: #fff0f0; color: #dc2626; }
        .tag-blue { background: #f0f4ff; color: #2563eb; }
        .tag-yellow { background: #fffbf0; color: #ca8a04; }
        .tag-green { background: #f0fff4; color: #16a34a; }

        /* ── Toolbar ── */
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; gap: 12px; flex-wrap: wrap; }
        .toolbar-left { display: flex; align-items: center; gap: 8px; }
        .section-title { font-size: 16px; font-weight: 700; color: #1a1a1a; }
        .section-sub { font-size: 13px; color: #888; }
        .search-wrap { position: relative; }
        .search-wrap input { padding: 9px 14px 9px 36px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 13px; color: #333; background: white; outline: none; width: 220px; transition: border-color 0.2s; font-family: inherit; }
        .search-wrap input:focus { border-color: #cc0000; }
        .search-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); font-size: 14px; color: #aaa; pointer-events: none; }
        .filter-select { padding: 9px 12px; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 13px; color: #555; background: white; outline: none; cursor: pointer; font-family: inherit; transition: border-color 0.2s; }
        .filter-select:focus { border-color: #cc0000; }
        .count-badge { background: #fff0f0; color: #cc0000; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; }

        /* ── Table ── */
        .table-card { background: white; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); overflow: hidden; }
        .table-card table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .table-card thead { background: #fafafa; border-bottom: 1px solid #eee; }
        .table-card th { padding: 13px 20px; text-align: left; font-size: 11px; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
        .table-card td { padding: 14px 20px; color: #333; border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
        .table-card tr:last-child td { border-bottom: none; }
        .table-card tr:hover td { background: #fafafa; }
        .donor-cell { display: flex; align-items: center; gap: 10px; }
        .donor-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #cc0000, #ff6666); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; flex-shrink: 0; }
        .donor-name { font-weight: 600; color: #1a1a1a; font-size: 14px; }
        .donor-id { font-size: 11px; color: #aaa; margin-top: 1px; }
        .blood-pill { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: #fff0f0; color: #cc0000; font-size: 12px; font-weight: 700; }
        .blood-empty { background: #f5f5f5; color: #bbb; font-size: 11px; width: auto; padding: 0 10px; border-radius: 20px; height: 26px; }
        .gender-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .gender-m { background: #eff6ff; color: #1d4ed8; }
        .gender-f { background: #fdf2f8; color: #9d174d; }
        .gender-u { background: #f5f5f5; color: #999; }
        .status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-complete { background: #f0fff4; color: #16a34a; }
        .status-partial { background: #fffbf0; color: #ca8a04; }
        .status-incomplete { background: #fff0f0; color: #dc2626; }
        .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .action-btn { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 8px; border: 1.5px solid #e5e7eb; background: white; cursor: pointer; font-size: 14px; transition: all 0.15s; text-decoration: none; }
        .action-btn:hover { border-color: #cc0000; background: #fff0f0; }
        .empty-state { text-align: center; padding: 64px 20px; color: #bbb; }
        .empty-state .big-icon { font-size: 52px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }

        /* ── Alert ── */
        .alert-success { background: #f0fff4; border: 1px solid #bbf7d0; color: #16a34a; padding: 12px 20px; border-radius: 10px; margin-bottom: 24px; font-size: 14px; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo">
            <div class="logo-icon">🩸</div>
            BloodDonate
        </div>
        <p>Management System</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Main Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.donors') }}" class="nav-item {{ request()->routeIs('admin.donors') ? 'active' : '' }}">
            <span class="icon">👥</span> Donors
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-info">
            <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="admin-name">{{ auth()->user()->name }}</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">🚪 Sign Out</button>
        </form>
    </div>
</aside>

<!-- Main -->
<div class="main">

    <div class="topbar">
        <div class="topbar-title">
            <h1>Donor Management</h1>
            <p>View and manage all registered donors</p>
        </div>
        <span class="date-badge">📅 {{ now()->format('F d, Y') }}</span>
    </div>

    <div class="content">

        @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon red">👥</div>
                <div>
                    <div class="stat-value">{{ $donors->count() }}</div>
                    <div class="stat-label">Total Donors</div>
                    <span class="stat-tag tag-red">Registered</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">🩸</div>
                <div>
                    <div class="stat-value">{{ $donors->filter(fn($d) => $d->donorProfile && $d->donorProfile->blood_type)->pluck('donorProfile.blood_type')->unique()->count() }}</div>
                    <div class="stat-label">Blood Types</div>
                    <span class="stat-tag tag-blue">Distinct</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">✅</div>
                <div>
                    <div class="stat-value">{{ $donors->filter(fn($d) => $d->donorProfile && $d->donorProfile->blood_type && $d->donorProfile->contact_number && $d->donorProfile->gender)->count() }}</div>
                    <div class="stat-label">Complete Profiles</div>
                    <span class="stat-tag tag-green">Full data</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">⚠️</div>
                <div>
                    <div class="stat-value">{{ $donors->filter(fn($d) => !$d->donorProfile || !$d->donorProfile->blood_type || !$d->donorProfile->contact_number)->count() }}</div>
                    <div class="stat-label">Incomplete</div>
                    <span class="stat-tag tag-yellow">Missing data</span>
                </div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <div>
                <div class="section-title">Donor Registry</div>
                <div class="section-sub">All registered blood donors</div>
            </div>
            <div class="toolbar-left">
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="searchInput" placeholder="Search donors..." oninput="filterRows()">
                </div>
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
                                    <div class="donor-id">D-{{ str_pad($donor->id, 3, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color:#666; font-size:13px;">{{ $donor->email }}</td>
                        <td>
                            @if($blood)
                                <span class="blood-pill">{{ $blood }}</span>
                            @else
                                <span class="blood-pill blood-empty">—</span>
                            @endif
                        </td>
                        <td style="color:#888; font-size:13px;">{{ $contact ?? '—' }}</td>
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
                                <div class="big-icon">🩸</div>
                                <p>No donors registered yet.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
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

</body>
</html>