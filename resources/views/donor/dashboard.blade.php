@extends('layouts.donor')

@section('content')
<style>
    * { box-sizing: border-box; }

    .donor-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        font-family: 'Segoe UI', sans-serif;
    }

    /* HERO */
    .welcome-banner {
        background: linear-gradient(135deg, #7a0000 0%, #cc0000 55%, #ff3333 100%);
        border-radius: 20px;
        padding: 44px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 280px; height: 280px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -100px; right: 140px;
        width: 320px; height: 320px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }
    .welcome-left { position: relative; z-index: 1; }
    .welcome-greeting {
        font-size: 12px;
        color: rgba(255,255,255,0.6);
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 8px;
        display: flex; align-items: center; gap: 6px;
    }
    .welcome-name {
        font-size: 32px;
        font-weight: 900;
        color: white;
        letter-spacing: -0.5px;
        margin-bottom: 10px;
    }
    .welcome-sub {
        font-size: 14px;
        color: rgba(255,255,255,0.65);
        display: flex; align-items: center; gap: 8px;
    }
    .pulse-dot {
        width: 9px; height: 9px;
        background: #66ff99;
        border-radius: 50%;
        animation: pulse 1.6s ease-in-out infinite;
    }
    @keyframes pulse {
        0%,100% { opacity:1; transform:scale(1); }
        50% { opacity:0.3; transform:scale(0.8); }
    }
    .welcome-right {
        position: relative; z-index: 1;
        display: flex; flex-direction: column;
        align-items: flex-end; gap: 14px;
    }
    .welcome-avatar {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        border: 3px solid rgba(255,255,255,0.35);
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; font-weight: 800; color: white;
    }
    .add-btn {
        background: white;
        color: #cc0000;
        border: none;
        padding: 11px 22px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px;
        transition: transform 0.2s, box-shadow 0.2s;
        font-family: 'Segoe UI', sans-serif;
    }
    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        color: #aa0000;
    }

    /* STATS */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        display: flex; align-items: center; gap: 14px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        transition: transform 0.2s;
        animation: fadeUp 0.5s ease both;
    }
    .stat-card:nth-child(1){animation-delay:0.05s}
    .stat-card:nth-child(2){animation-delay:0.10s}
    .stat-card:nth-child(3){animation-delay:0.15s}
    .stat-card:nth-child(4){animation-delay:0.20s}
    .stat-card:hover { transform: translateY(-3px); }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .stat-icon-box {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; flex-shrink: 0;
    }
    .icon-red    { background: #fff0f0; }
    .icon-blue   { background: #eef2ff; }
    .icon-yellow { background: #fffbeb; }
    .icon-green  { background: #f0fdf4; }
    .stat-val { font-size: 28px; font-weight: 800; color: #1a1a1a; line-height: 1; }
    .stat-lbl { font-size: 12px; color: #999; margin-top: 3px; }

    /* IMPACT + PROFILE GRID */
    .impact-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 28px;
    }
    .impact-card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        animation: fadeUp 0.5s ease 0.25s both;
    }
    .impact-card .card-title { font-size: 15px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
    .impact-card .card-sub   { font-size: 12px; color: #bbb; margin-bottom: 16px; }

    /* Lives circles */
    .lives-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 10px; }
    .life-circle {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7a0000, #cc0000);
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; color: white;
        animation: popIn 0.4s ease both;
    }
    @keyframes popIn {
        from { opacity:0; transform:scale(0); }
        to   { opacity:1; transform:scale(1); }
    }
    .life-label { font-size: 11px; color: #aaa; margin-top: 4px; }

    /* Blood chip */
    .blood-chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fff0f0;
        border: 1.5px solid #ffd0d0;
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 14px; font-weight: 700; color: #cc0000;
    }

    /* Countdown */
    .countdown-row { display: flex; gap: 10px; margin-top: 10px; }
    .count-box {
        background: #fff0f0;
        border-radius: 10px;
        padding: 12px 16px;
        text-align: center; flex: 1;
    }
    .count-num { font-size: 22px; font-weight: 800; color: #cc0000; line-height: 1; }
    .count-lbl { font-size: 10px; color: #cc0000; opacity: 0.6; margin-top: 3px; text-transform: uppercase; letter-spacing: 0.5px; }

    /* TIPS */
    .tips-card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        margin-bottom: 28px;
        animation: fadeUp 0.5s ease 0.35s both;
    }
    .tips-card .card-title { font-size: 15px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
    .tips-card .card-sub   { font-size: 12px; color: #bbb; margin-bottom: 16px; }
    .tips-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }
    .tip {
        background: #fafafa;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        border: 1px solid #f0f0f0;
    }
    .tip-icon  { font-size: 24px; margin-bottom: 8px; }
    .tip-title { font-size: 13px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
    .tip-text  { font-size: 11px; color: #aaa; line-height: 1.5; }

    /* TABLE */
    .table-section { animation: fadeUp 0.5s ease 0.4s both; }
    .section-head {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 14px;
    }
    .section-title { font-size: 16px; font-weight: 700; color: #1a1a1a; }
    .section-sub   { font-size: 12px; color: #aaa; margin-top: 2px; }

    .table-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .table-card table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .table-card thead { background: linear-gradient(90deg, #7a0000, #cc0000); }
    .table-card th {
        padding: 14px 20px;
        text-align: left;
        font-size: 11px; font-weight: 700;
        color: rgba(255,255,255,0.85);
        text-transform: uppercase; letter-spacing: 0.6px;
    }
    .table-card td {
        padding: 15px 20px;
        color: #333;
        border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }
    .table-card tr:last-child td { border-bottom: none; }
    .table-card tbody tr:hover td { background: #fdf5f5; }

    .row-num {
        width: 28px; height: 28px;
        background: #f5f5f5; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700; color: #888;
    }
    .date-cell       { font-weight: 600; color: #1a1a1a; }
    .date-cell span  { display:block; font-size:11px; font-weight:400; color:#aaa; margin-top:2px; }
    .packs-cell      { font-weight: 700; font-size: 16px; color: #cc0000; }
    .packs-cell small{ font-size:11px; font-weight:400; color:#aaa; }

    .badge          { padding:5px 14px; border-radius:20px; font-size:12px; font-weight:700; display:inline-block; }
    .badge-pending  { background:#fffbf0; color:#ca8a04; border:1px solid #fde68a; }
    .badge-approved { background:#f0fff4; color:#16a34a; border:1px solid #bbf7d0; }
    .badge-rejected { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }

    .notes-cell {
        max-width: 180px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        color: #666; font-size: 13px;
    }
    .action-wrap { display:flex; gap:8px; align-items:center; }
    .btn-edit {
        padding:6px 16px;
        background:#f0f4ff; color:#2563eb;
        border:1px solid #bfdbfe; border-radius:8px;
        font-size:12px; font-weight:700;
        text-decoration:none;
        transition:all 0.15s;
        display:inline-flex; align-items:center; gap:4px;
    }
    .btn-edit:hover { background:#2563eb; color:white; border-color:#2563eb; }
    .btn-del {
        padding:6px 16px;
        background:#fff0f0; color:#dc2626;
        border:1px solid #fecaca; border-radius:8px;
        font-size:12px; font-weight:700;
        cursor:pointer;
        transition:all 0.15s;
        display:inline-flex; align-items:center; gap:4px;
        font-family:'Segoe UI',sans-serif;
    }
    .btn-del:hover { background:#dc2626; color:white; border-color:#dc2626; }
    .locked-tag { font-size:12px; color:#ccc; font-style:italic; display:flex; align-items:center; gap:4px; }

    /* EMPTY */
    .empty-state { text-align:center; padding:70px 20px; }
    .empty-icon  { font-size:52px; margin-bottom:14px; }
    .empty-state h3 { font-size:17px; font-weight:700; color:#333; margin-bottom:8px; }
    .empty-state p  { font-size:14px; color:#aaa; margin-bottom:20px; }
    .empty-cta {
        display:inline-flex; align-items:center; gap:7px;
        background:#cc0000; color:white;
        padding:11px 24px; border-radius:10px;
        font-size:14px; font-weight:700;
        text-decoration:none; transition:all 0.2s;
    }
    .empty-cta:hover { background:#aa0000; transform:translateY(-1px); }

    /* ALERT */
    .alert-ok {
        background:#f0fff4; border:1px solid #bbf7d0;
        color:#16a34a;
        padding:12px 18px; border-radius:12px;
        margin-bottom:24px;
        font-size:14px; font-weight:500;
        display:flex; align-items:center; gap:8px;
    }
</style>

<div class="donor-wrapper">

    @if(session('success'))
    <div class="alert-ok">✅ {{ session('success') }}</div>
    @endif

    {{-- HERO BANNER --}}
    <div class="welcome-banner">
        <div class="welcome-left">
            <div class="welcome-greeting">📅 {{ now()->format('l, F d Y') }}</div>
            <div class="welcome-name">Welcome back, {{ auth()->user()->name }}! 👋</div>
            <div class="welcome-sub">
                <span class="pulse-dot"></span>
                Your donation journey is making a difference
            </div>
        </div>
        <div class="welcome-right">
            <div class="welcome-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <a href="{{ route('donor.donate') }}" class="add-btn">🩸 Add Donation</a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon-box icon-red">💉</div>
            <div>
                <div class="stat-val">{{ $donations->count() }}</div>
                <div class="stat-lbl">Total Donations</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-box icon-blue">🩸</div>
            <div>
                <div class="stat-val">{{ $donations->sum('packs') }}</div>
                <div class="stat-lbl">Total Packs</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-box icon-yellow">⏳</div>
            <div>
                <div class="stat-val">{{ $donations->where('status','pending')->count() }}</div>
                <div class="stat-lbl">Pending</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-box icon-green">✅</div>
            <div>
                <div class="stat-val">{{ $donations->where('status','approved')->count() }}</div>
                <div class="stat-lbl">Approved</div>
            </div>
        </div>
    </div>

    {{-- IMPACT + PROFILE --}}
    <div class="impact-section">

        {{-- Lives Impacted --}}
        <div class="impact-card">
            <div class="card-title">Lives You've Impacted 🎉</div>
            <div class="card-sub">Each pack of blood can save up to 3 lives</div>
            @php $totalPacks = $donations->sum('packs'); $livesEmojis = ['❤️','🫀','🧠','👁️','🦷','🦴','💊','🩺']; @endphp
            <div class="lives-row">
                @for($i = 0; $i < min($totalPacks, 16); $i++)
                    <div class="life-circle" style="animation-delay: {{ $i * 0.06 }}s">
                        {{ $livesEmojis[$i % count($livesEmojis)] }}
                    </div>
                @endfor
            </div>
            <div class="life-label">{{ $totalPacks * 3 }} lives potentially saved from your {{ $totalPacks }} pack(s)</div>
        </div>

        {{-- Donor Profile Snapshot --}}
        <div class="impact-card">
            <div class="card-title">Your Donor Profile</div>
            <div class="card-sub">Quick health summary</div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                <div class="blood-chip">
                    🩸 Blood Type: {{ optional($profile)->blood_type ?? 'Not set' }}
                </div>
                @if(optional($profile)->gender)
                    <span style="font-size:12px;color:#aaa;">{{ $profile->gender }}</span>
                @endif
            </div>
            @php
                $lastDonation = $donations->where('status','approved')->sortByDesc('donation_date')->first();
                $daysLeft = $lastDonation
                    ? max(0, 56 - \Carbon\Carbon::parse($lastDonation->donation_date)->diffInDays(now()))
                    : null;
            @endphp
            @if($daysLeft !== null)
                <div style="font-size:12px;color:#999;margin-bottom:8px;">Next eligible donation in:</div>
                <div class="countdown-row">
                    <div class="count-box">
                        <div class="count-num">{{ $daysLeft }}</div>
                        <div class="count-lbl">Days</div>
                    </div>
                    <div class="count-box">
                        <div class="count-num">{{ now()->diffInHours(now()->addDays($daysLeft)) % 24 }}</div>
                        <div class="count-lbl">Hours</div>
                    </div>
                    <div class="count-box">
                        <div class="count-num">{{ now()->minute }}</div>
                        <div class="count-lbl">Mins</div>
                    </div>
                </div>
            @else
                <div style="font-size:13px;color:#aaa;margin-top:8px;">No approved donations yet — you're ready to donate! 🩸</div>
            @endif
        </div>

    </div>

    {{-- TIPS --}}
    <div class="tips-card">
        <div class="card-title">Tips Before Your Next Donation</div>
        <div class="card-sub">Stay healthy, save more lives</div>
        <div class="tips-grid">
            <div class="tip">
                <div class="tip-icon">💧</div>
                <div class="tip-title">Stay Hydrated</div>
                <div class="tip-text">Drink at least 2 glasses of water before donating blood.</div>
            </div>
            <div class="tip">
                <div class="tip-icon">🥗</div>
                <div class="tip-title">Eat Well</div>
                <div class="tip-text">Have a healthy meal high in iron before your donation.</div>
            </div>
            <div class="tip">
                <div class="tip-icon">😴</div>
                <div class="tip-title">Rest Properly</div>
                <div class="tip-text">Get at least 8 hours of sleep before your donation day.</div>
            </div>
        </div>
    </div>

    {{-- DONATIONS TABLE --}}
    <div class="table-section">
        <div class="section-head">
            <div>
                <div class="section-title">My Donation Records</div>
                <div class="section-sub">Showing all {{ $donations->count() }} record(s)</div>
            </div>
        </div>

        <div class="table-card">
            @if($donations->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🩸</div>
                <h3>No donations yet</h3>
                <p>Start your donation journey and help save lives today!</p>
                <a href="{{ route('donor.donate') }}" class="empty-cta">+ Add Your First Donation</a>
            </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Packs</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donations as $i => $donation)
                    <tr>
                        <td><div class="row-num">{{ $i + 1 }}</div></td>
                        <td>
                            <div class="date-cell">
                                {{ \Carbon\Carbon::parse($donation->donation_date)->format('M d, Y') }}
                                <span>{{ \Carbon\Carbon::parse($donation->donation_date)->diffForHumans() }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="packs-cell">
                                {{ $donation->packs }} <small>pack(s)</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $donation->status }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="notes-cell" title="{{ $donation->notes }}">
                                {{ $donation->notes ?? '—' }}
                            </div>
                        </td>
                        <td>
                            @if($donation->status === 'pending')
                            <div class="action-wrap">
                                <a href="{{ route('donor.edit', $donation->id) }}" class="btn-edit">✏️ Edit</a>
                                <form action="{{ route('donor.destroy', $donation->id) }}" method="POST"
                                      onsubmit="return confirm('Delete this donation?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del">🗑️ Delete</button>
                                </form>
                            </div>
                            @else
                            <div class="locked-tag">🔒 Locked</div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>
@endsection