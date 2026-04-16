<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fb; min-height: 100vh; display: flex; }

        /* Sidebar */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #7a0000;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }

        .sidebar-brand {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand .logo {
            font-size: 20px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand .logo-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .sidebar-brand p {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            margin-top: 4px;
            padding-left: 46px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 700;
            color: rgba(255,255,255,0.35);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 12px 24px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            margin: 1px 0;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }

        .nav-item.active {
            background: rgba(255,255,255,0.12);
            color: white;
            border-left-color: #ff6666;
            font-weight: 600;
        }

        .nav-item .icon {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .admin-avatar {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            color: white;
            font-weight: 700;
        }

        .admin-name {
            font-size: 13px;
            font-weight: 600;
            color: white;
        }

        .admin-role {
            font-size: 11px;
            color: rgba(255,255,255,0.45);
        }

        .logout-btn {
            width: 100%;
            padding: 9px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            color: rgba(255,255,255,0.7);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        /* Main content */
        .main {
            margin-left: 240px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top bar */
        .topbar {
            background: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title h1 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .topbar-title p {
            font-size: 13px;
            color: #888;
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .date-badge {
            font-size: 13px;
            color: #666;
            background: #f4f4f4;
            padding: 6px 14px;
            border-radius: 20px;
        }

        /* Content area */
        .content {
            padding: 32px;
            flex: 1;
        }

        /* Stat cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-icon.red { background: #fff0f0; }
        .stat-icon.blue { background: #f0f4ff; }
        .stat-icon.yellow { background: #fffbf0; }
        .stat-icon.green { background: #f0fff4; }

        .stat-info { flex: 1; }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
            line-height: 1;
        }

        .stat-label {
            font-size: 13px;
            color: #888;
            margin-top: 4px;
        }

        .stat-change {
            font-size: 11px;
            margin-top: 6px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 600;
        }

        .stat-change.up { background: #f0fff4; color: #16a34a; }
        .stat-change.pending { background: #fffbf0; color: #ca8a04; }

        /* Section header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .section-sub {
            font-size: 13px;
            color: #888;
            margin-top: 2px;
        }

        /* Table */
        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .table-card table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-card thead {
            background: #fafafa;
            border-bottom: 1px solid #eee;
        }

        .table-card th {
            padding: 13px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-card td {
            padding: 14px 20px;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: middle;
        }

        .table-card tr:last-child td { border-bottom: none; }

        .table-card tr:hover td { background: #fafafa; }

        /* Donor avatar in table */
        .donor-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .donor-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #cc0000, #ff6666);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .donor-name { font-weight: 600; color: #1a1a1a; font-size: 14px; }
        .donor-email { font-size: 12px; color: #888; }

        /* Status badges */
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-pending { background: #fffbf0; color: #ca8a04; }
        .badge-approved { background: #f0fff4; color: #16a34a; }
        .badge-rejected { background: #fff0f0; color: #dc2626; }

        /* Status select */
        .status-select {
            padding: 6px 10px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            color: #333;
            background: white;
            cursor: pointer;
            outline: none;
            transition: border-color 0.2s;
        }

        .status-select:focus { border-color: #cc0000; }

        .update-btn {
            padding: 6px 14px;
            background: #7a0000;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .update-btn:hover { background: #cc0000; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #aaa;
        }

        .empty-state .icon { font-size: 48px; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; }

        /* Alert */
        .alert-success {
            background: #f0fff4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
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
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.donors') }}"
           class="nav-item {{ request()->routeIs('admin.donors') ? 'active' : '' }}">
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
            <button type="submit" class="logout-btn">
                🚪 Sign Out
            </button>
        </form>
    </div>
</aside>

<!-- Main Content -->
<div class="main">

    <!-- Top Bar -->
    <div class="topbar">
        <div class="topbar-title">
            <h1>Admin Dashboard</h1>
            <p>Overview of all blood donations</p>
        </div>
        <div class="topbar-right">
            <span class="date-badge">📅 {{ now()->format('F d, Y') }}</span>
        </div>
    </div>

    <!-- Content -->
    <div class="content">

        @if(session('success'))
        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon red">🩸</div>
                <div class="stat-info">
                    <div class="stat-value">{{ $totalDonors ?? 0 }}</div>
                    <div class="stat-label">Total Donors</div>
                    <span class="stat-change up">↑ Registered</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">💉</div>
                <div class="stat-info">
                    <div class="stat-value">{{ $totalDonations ?? 0 }}</div>
                    <div class="stat-label">Total Donations</div>
                    <span class="stat-change up">↑ All time</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">⏳</div>
                <div class="stat-info">
                    <div class="stat-value">{{ $pendingDonations ?? 0 }}</div>
                    <div class="stat-label">Pending</div>
                    <span class="stat-change pending">⚠ Needs review</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">✅</div>
                <div class="stat-info">
                    <div class="stat-value">{{ $approvedDonations ?? 0 }}</div>
                    <div class="stat-label">Approved</div>
                    <span class="stat-change up">↑ Completed</span>
                </div>
            </div>
        </div>

        <!-- Donations Table -->
        <div class="section-header">
            <div>
                <div class="section-title">Recent Donations</div>
                <div class="section-sub">Manage and update donation statuses</div>
            </div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Date</th>
                        <th>Packs</th>
                        <th>Status</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                    <tr>
                        <td>
                            <div class="donor-cell">
                                <div class="donor-avatar">
                                    {{ strtoupper(substr($donation->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="donor-name">{{ $donation->user->name ?? 'Unknown' }}</div>
                                    <div class="donor-email">{{ $donation->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($donation->donation_date)->format('M d, Y') }}</td>
                        <td><strong>{{ $donation->packs }}</strong> pack(s)</td>
                        <td>
                            <span class="badge badge-{{ $donation->status }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.donations.status', $donation->id) }}"
                                  method="POST" style="display:flex; gap:8px; align-items:center;">
                                @csrf
                                <select name="status" class="status-select">
                                    <option value="pending" {{ $donation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $donation->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $donation->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" class="update-btn">Save</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="icon">🩸</div>
                                <p>No donations found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>