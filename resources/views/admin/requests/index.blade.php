@extends('layouts.admin')

@section('content')

<!-- Top Bar -->
<div class="topbar">
    <div class="topbar-title">
        <h1>Blood Requests</h1>
        <p>Review and fulfill blood requests from donors</p>
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
        <div class="stat-icon yellow">⏳</div>
        <div class="stat-info">
            <div class="stat-value">{{ $pending ?? 0 }}</div>
            <div class="stat-label">Pending Requests</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div class="stat-info">
            <div class="stat-value">{{ $fulfilled ?? 0 }}</div>
            <div class="stat-label">Fulfilled</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">❌</div>
        <div class="stat-info">
            <div class="stat-value">{{ $rejected ?? 0 }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>
</div>

<!-- Requests Table -->
<div class="section-header">
    <div>
        <div class="section-title">All Requests</div>
        <div class="section-sub">Manage and update request statuses</div>
    </div>
    <div style="display:flex; gap:10px;">
        <select id="statusFilter" class="search-input" style="width:140px;">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="fulfilled">Fulfilled</option>
            <option value="rejected">Rejected</option>
        </select>
        <select id="bloodTypeFilter" class="search-input" style="width:140px;">
            <option value="">All Blood Type</option>
            <option value="a+">A+</option>
            <option value="a-">A-</option>
            <option value="b+">B+</option>
            <option value="b-">B-</option>
            <option value="ab+">AB+</option>
            <option value="ab-">AB-</option>
            <option value="o+">O+</option>
            <option value="o-">O-</option>
        </select>
        <input type="text" id="searchInput" class="search-input" placeholder="Search by donor name...">
    </div>
</div>

<div class="table-card">
    <table id="requestsTable">
        <thead>
            <tr>
                <th>Donor</th>
                <th>Blood Type</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            <tr data-status="{{ strtolower($req->status) }}" data-blood="{{ strtolower($req->blood_type) }}">
                <td>
                    <div class="donor-cell">
                        <div class="donor-avatar">
                            {{ strtoupper(substr($req->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="donor-name">{{ $req->user->name ?? 'Unknown' }}</div>
                            <div class="donor-email">{{ $req->user->email ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td><strong style="color:#cc0000; font-size:16px;">{{ $req->blood_type ?? '-' }}</strong></td>
                <td><strong>{{ $req->packs_needed ?? '-' }}</strong> packs</td>
                <td><span class="badge badge-{{ $req->status }}">{{ ucfirst($req->status) }}</span></td>
                <td>{{ \Carbon\Carbon::parse($req->created_at)->format('M d, Y') }}</td>
                <td>
                    @if($req->status === 'fulfilled')
                        <span style="color:#16a34a; font-weight:700; font-size: 14px; background: #f0fff4; padding: 6px 12px; border-radius: 8px;">✔ Fulfilled</span>
                    @elseif($req->status === 'rejected')
                        <span style="color:#dc2626; font-weight:700; font-size: 14px; background: #fff0f0; padding: 6px 12px; border-radius: 8px;">❌ Rejected</span>
                    @else
                    <form action="{{ route('admin.requests.update', $req->id) }}" method="POST" style="display:flex; gap:8px; align-items:center;">
                        @csrf
                        @method('PUT')
                        <select name="status" class="status-select">
                            <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="fulfilled" {{ $req->status === 'fulfilled' ? 'selected' : '' }}>Fulfill</option>
                            <option value="rejected" {{ $req->status === 'rejected' ? 'selected' : '' }}>Reject</option>
                        </select>
                        <button type="submit" class="update-btn">Save</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="icon">📭</div>
                        <p>No blood requests found yet.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function filterRequests() {
        let textFilter = document.getElementById('searchInput').value.toLowerCase();
        let statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        let bloodFilter = document.getElementById('bloodTypeFilter').value.toLowerCase();
        let rows = document.querySelectorAll('#requestsTable tbody tr');
        
        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;
            let text = row.querySelector('.donor-name').textContent.toLowerCase();
            let status = row.getAttribute('data-status') || '';
            let blood = row.getAttribute('data-blood') || '';
            
            let matchesText = text.includes(textFilter);
            let matchesStatus = statusFilter === '' || status === statusFilter;
            let matchesBlood = bloodFilter === '' || blood === bloodFilter;
            
            row.style.display = (matchesText && matchesStatus && matchesBlood) ? '' : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('keyup', filterRequests);
    document.getElementById('statusFilter').addEventListener('change', filterRequests);
    document.getElementById('bloodTypeFilter').addEventListener('change', filterRequests);
</script>
@endsection