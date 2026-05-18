@extends('layouts.donor')

@section('content')
<style>
    /* HERO */
    .welcome-banner {
        background: linear-gradient(135deg, #7a0000 0%, #cc0000 55%, #ff3333 100%);
        border-radius: 20px; padding: 44px 40px;
        display: flex; align-items: center; justify-content: flex-start;
        margin-bottom: 32px; position: relative; overflow: hidden;
    }
    .welcome-banner::before { content: ''; position: absolute; top: -80px; right: -80px; width: 280px; height: 280px; background: rgba(255,255,255,0.05); border-radius: 50%; }
    .welcome-banner::after { content: ''; position: absolute; bottom: -100px; right: 140px; width: 320px; height: 320px; background: rgba(255,255,255,0.04); border-radius: 50%; }
    .welcome-left { position: relative; z-index: 1; }
    .welcome-greeting { font-size: 12px; color: rgba(255,255,255,0.6); letter-spacing: 1px; text-transform: uppercase; margin-bottom: 8px; }
    .welcome-name { font-size: 32px; font-weight: 900; color: white; letter-spacing: -0.5px; margin-bottom: 10px; }
    .welcome-sub { font-size: 14px; color: rgba(255,255,255,0.65); display: flex; align-items: center; gap: 8px; }
    .pulse-dot { width: 9px; height: 9px; background: #66ff99; border-radius: 50%; animation: pulse 1.6s ease-in-out infinite; }
    @keyframes pulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:0.3; transform:scale(0.8); } }

    /* IMPACT + PROFILE GRID */
    .impact-section { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px; }
    .impact-card { background: white; border-radius: 20px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02); }
    .impact-card .card-title { font-size: 16px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px; }
    .impact-card .card-sub   { font-size: 13px; color: #64748b; margin-bottom: 20px; }

    /* Lives circles */
    .lives-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; }
    .life-circle { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #7a0000, #cc0000); display: flex; align-items: center; justify-content: center; font-size: 16px; color: white; animation: popIn 0.4s ease both; box-shadow: 0 2px 8px rgba(204,0,0,0.3); }
    @keyframes popIn { from { opacity:0; transform:scale(0); } to { opacity:1; transform:scale(1); } }
    .life-label { font-size: 12px; color: #64748b; font-weight: 500; }

    /* Blood chip */
    .blood-chip { display: inline-flex; align-items: center; gap: 8px; background: #fff0f0; border: 1px solid #ffcccc; border-radius: 20px; padding: 8px 16px; font-size: 14px; font-weight: 700; color: #cc0000; }

    /* Countdown */
    .countdown-row { display: flex; gap: 12px; margin-top: 12px; }
    .count-box { background: #fff0f0; border-radius: 12px; padding: 14px 16px; text-align: center; flex: 1; border: 1px solid rgba(204,0,0,0.05); }
    .count-num { font-size: 24px; font-weight: 800; color: #cc0000; line-height: 1; }
    .count-lbl { font-size: 11px; color: #cc0000; opacity: 0.7; margin-top: 4px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

    /* TIPS */
    .tips-card { background: white; border-radius: 20px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 32px; border: 1px solid rgba(0,0,0,0.02); }
    .tips-card .card-title { font-size: 16px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px; }
    .tips-card .card-sub   { font-size: 13px; color: #64748b; margin-bottom: 20px; }
    .tips-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .tip { background: #f8f9fb; border-radius: 16px; padding: 20px; text-align: center; border: 1px solid #f1f5f9; transition: transform 0.2s; }
    .tip:hover { transform: translateY(-2px); }
    .tip-icon  { font-size: 28px; margin-bottom: 12px; }
    .tip-title { font-size: 14px; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
    .tip-text  { font-size: 12px; color: #64748b; line-height: 1.5; }
</style>

<div class="page-wrapper">

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
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon red">💉</div>
            <div class="stat-info">
                <div class="stat-value">{{ $donations->count() }}</div>
                <div class="stat-label">Total Donations</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">🩸</div>
            <div class="stat-info">
                <div class="stat-value">{{ $donations->sum('packs') }}</div>
                <div class="stat-label">Total Packs</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">⏳</div>
            <div class="stat-info">
                <div class="stat-value">{{ $donations->where('status','pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div class="stat-info">
                <div class="stat-value">{{ $donations->where('status','approved')->count() }}</div>
                <div class="stat-label">Approved</div>
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
                @if($totalPacks == 0)
                    <div style="font-size:13px;color:#aaa;padding:10px 0;">Start donating to see your impact here!</div>
                @endif
            </div>
            <div class="life-label">{{ $totalPacks * 3 }} lives potentially saved from your {{ $totalPacks }} pack(s)</div>
        </div>

        {{-- Donor Profile Snapshot --}}
        <div class="impact-card">
            <div class="card-title">Your Donor Profile</div>
            <div class="card-sub">Quick health summary</div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <div class="blood-chip">
                    🩸 Blood Type: {{ optional($profile)->blood_type ?? 'Not set' }}
                </div>
                @if(optional($profile)->gender)
                    <span style="font-size:13px;color:#64748b;font-weight:500;">{{ $profile->gender }}</span>
                @endif
            </div>
            @php
                $lastDonation = $donations->where('status','approved')->sortByDesc('donation_date')->first();
                $daysLeft = $lastDonation
                    ? max(0, 56 - floor(\Carbon\Carbon::parse($lastDonation->donation_date)->diffInDays(now())))
                    : null;
            @endphp
            @if($daysLeft !== null && $daysLeft > 0)
                <div style="font-size:13px;color:#64748b;margin-bottom:8px;font-weight:500;">Next eligible donation in:</div>
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
                <div style="font-size:14px;color:#16a34a;margin-top:10px;font-weight:600;background:#f0fff4;padding:12px;border-radius:10px;border:1px solid #bbf7d0;">
                    You're ready to donate! 🩸 Book an appointment today.
                </div>
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
    <div class="section-header">
        <div>
            <div class="section-title">My Donation Records</div>
            <div class="section-sub">Showing all {{ $donations->count() }} record(s)</div>
        </div>
    </div>

    <div class="table-card">
        @if($donations->isEmpty())
        <div class="empty-state">
            <div class="icon">🩸</div>
            <p style="font-weight:bold; color:#334155;">No donations yet</p>
            <p>Start your donation journey and help save lives today!</p>
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
                    <td style="font-weight:bold; color:#94a3b8;">{{ $i + 1 }}</td>
                    <td>
                        <div style="font-weight: 600; color: #1e293b;">
                            {{ \Carbon\Carbon::parse($donation->donation_date)->format('M d, Y') }}
                        </div>
                        <div style="font-size:11px; color:#94a3b8; margin-top:2px;">
                            {{ \Carbon\Carbon::parse($donation->donation_date)->diffForHumans() }}
                        </div>
                    </td>
                    <td>
                        <strong style="font-size: 16px; color: #cc0000;">{{ $donation->packs }}</strong> <span style="font-size:12px; color:#94a3b8;">pack(s)</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $donation->status }}">
                            {{ ucfirst($donation->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #64748b; font-size: 13px;" title="{{ $donation->notes }}">
                            {{ $donation->notes ?? '—' }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size:12px; color:#94a3b8; font-style:italic; display:flex; align-items:center; gap:4px; font-weight:500;">
                            🔒 Recorded by Admin
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection