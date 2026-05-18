@extends('layouts.admin')

@section('content')

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

@if(session('success'))
<div class="alert-success">
    ✅ {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert-error">
    ❌ {{ session('error') }}
</div>
@endif

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon red">🩸</div>
        <div class="stat-info">
            <div class="stat-value">{{ $totalDonors ?? 0 }}</div>
            <div class="stat-label">Total Donors</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">💉</div>
        <div class="stat-info">
            <div class="stat-value">{{ $totalDonations ?? 0 }}</div>
            <div class="stat-label">Total Donations</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">⏳</div>
        <div class="stat-info">
            <div class="stat-value">{{ $pending ?? 0 }}</div>
            <div class="stat-label">Pending Reviews</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div class="stat-info">
            <div class="stat-value">{{ $approved ?? 0 }}</div>
            <div class="stat-label">Approved</div>
        </div>
    </div>
</div>

<!-- Donations Table -->
<div class="section-header">
    <div>
        <div class="section-title">Recent Donations</div>
        <div class="section-sub">Manage and update donation statuses</div>
    </div>
    <div style="display:flex; gap:10px;">
        <select id="statusFilter" class="search-input" style="width:150px;">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
        <input type="text" id="searchDonation" class="search-input" placeholder="Search donors...">
    </div>
</div>

<div class="table-card">
    <table id="donationsTable">
        <thead>
            <tr>
                <th>Donor</th>
                <th>Date</th>
                <th>Packs</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations ?? [] as $donation)
            <tr data-status="{{ strtolower($donation->status) }}">
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
                <td><strong style="color:#1a1a1a;">{{ $donation->packs }}</strong> pack(s)</td>
                <td>
                    <span class="badge badge-{{ $donation->status }}">
                        {{ ucfirst($donation->status) }}
                    </span>
                </td>
                <td>
                    @if($donation->status === 'approved')
                        <span style="color:#16a34a; font-weight:700; font-size: 14px; background: #f0fff4; padding: 6px 12px; border-radius: 8px;">✔ Approved</span>
                    @elseif($donation->status === 'rejected')
                        <span style="color:#dc2626; font-weight:700; font-size: 14px; background: #fff0f0; padding: 6px 12px; border-radius: 8px;">❌ Rejected</span>
                    @else
                    <form action="{{ route('admin.donations.status', $donation->id) }}"
                            method="POST" style="display:flex; gap:8px; align-items:center;">
                        @csrf
                        <select name="status" class="status-select">
                            <option value="pending" {{ $donation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $donation->status === 'approved' ? 'selected' : '' }}>Approve</option>
                            <option value="rejected" {{ $donation->status === 'rejected' ? 'selected' : '' }}>Reject</option>
                        </select>
                        <button type="submit" class="update-btn">Save</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="icon">📭</div>
                        <p>No donations found yet.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function filterDonations() {
        let textFilter = document.getElementById('searchDonation').value.toLowerCase();
        let statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        let rows = document.querySelectorAll('#donationsTable tbody tr');
        
        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;
            let text = row.textContent.toLowerCase();
            let status = row.getAttribute('data-status') || '';
            
            let matchesText = text.includes(textFilter);
            let matchesStatus = statusFilter === '' || status === statusFilter;
            
            row.style.display = (matchesText && matchesStatus) ? '' : 'none';
        });
    }

    document.getElementById('searchDonation').addEventListener('keyup', filterDonations);
    document.getElementById('statusFilter').addEventListener('change', filterDonations);
</script>
@endsection