@extends('layouts.admin')

@section('content')
<style>
    .inventory-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
    .blood-card { 
        background: white; border-radius: 24px; padding: 32px 24px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.03); text-align: center; 
        border: 1px solid rgba(0,0,0,0.02); position: relative; overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .blood-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.06); }
    .blood-type { font-size: 36px; font-weight: 900; color: #cc0000; margin-bottom: 4px; letter-spacing: -1px; }
    .blood-units { font-size: 48px; font-weight: 800; color: #1a1a1a; line-height: 1; letter-spacing: -1px; }
    .blood-label { font-size: 14px; font-weight: 500; color: #64748b; margin-bottom: 20px; margin-top: 4px; }
    .unit-form { display: flex; gap: 8px; align-items: center; justify-content: center; margin-top: 24px; }
    .unit-input { width: 80px; padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; text-align: center; font-size: 15px; font-weight: 600; font-family: inherit; transition: border-color 0.2s; outline: none; }
    .unit-input:focus { border-color: #cc0000; box-shadow: 0 0 0 3px rgba(204,0,0,0.1); }
    .btn-update { padding: 8px 18px; background: #cc0000; color: white; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 5px rgba(204,0,0,0.2); }
    .btn-update:hover { background: #a00000; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(204,0,0,0.3); }
    
    .low-stock { border: 2px solid #fde68a; background: linear-gradient(180deg, #fffbeb, white); }
    .no-stock { border: 2px solid #fca5a5; background: linear-gradient(180deg, #fff5f5, white); }
    
    .status-badge { display: inline-flex; align-items: center; justify-content: center; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.5px; }
    .status-ok { background: #f0fff4; color: #16a34a; }
    .status-low { background: #fffbf0; color: #ca8a04; }
    .status-out { background: #fff0f0; color: #dc2626; }
</style>

<!-- Top Bar -->
<div class="topbar">
    <div class="topbar-title">
        <h1>🩸 Blood Inventory</h1>
        <p>Manage and monitor blood stock levels across all blood types</p>
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

<div class="inventory-grid">
    @foreach($inventory as $item)
    <div class="blood-card {{ $item->units == 0 ? 'no-stock' : ($item->units <= 5 ? 'low-stock' : '') }}">
        <div class="blood-type">{{ $item->blood_type }}</div>
        <div class="blood-units">{{ $item->units }}</div>
        <div class="blood-label">units available</div>
        
        <div>
            @if($item->units == 0)
                <span class="status-badge status-out">⚠️ OUT OF STOCK</span>
            @elseif($item->units <= 5)
                <span class="status-badge status-low">⚠️ LOW STOCK</span>
            @else
                <span class="status-badge status-ok">✅ ADEQUATE</span>
            @endif
        </div>
        
        <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST" class="unit-form">
            @csrf
            @method('PUT')
            <input type="number" name="units" value="{{ $item->units }}" min="0" class="unit-input" aria-label="Units">
            <button type="submit" class="btn-update">Update</button>
        </form>
    </div>
    @endforeach
</div>

@endsection
