<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f4f6f9; display: flex; min-height: 100vh; }
        
        /* Premium Glassmorphism Sidebar */
        .sidebar { 
            width: 250px; 
            min-height: 100vh; 
            background: linear-gradient(180deg, rgba(139,0,0,0.95), rgba(200,0,0,0.85)); 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px);
            position: fixed; 
            top: 0; left: 0; 
            display: flex; flex-direction: column; 
            box-shadow: 4px 0 24px rgba(0,0,0,0.1);
            z-index: 100;
        }
        
        .sidebar-brand { padding: 28px 24px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand .brand-name { color: white; font-size: 20px; font-weight: 800; letter-spacing: -0.5px; }
        .sidebar-brand .brand-sub { color: rgba(255,255,255,0.7); font-size: 12px; margin-top: 4px; font-weight: 500; }
        
        .sidebar nav { padding: 20px 0; flex: 1; }
        .nav-item { 
            display: flex; align-items: center; gap: 12px; 
            padding: 14px 24px; color: rgba(255,255,255,0.75); 
            text-decoration: none; font-size: 14px; font-weight: 500; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            border-left: 3px solid transparent;
        }
        .nav-item:hover { 
            background: rgba(255,255,255,0.1); color: white; 
            transform: translateX(4px);
        }
        .nav-item.active { 
            background: rgba(255,255,255,0.15); color: white; 
            border-left-color: #ffcccc; font-weight: 600;
        }
        .nav-item .icon { font-size: 18px; width: 24px; text-align: center; }
        
        .sidebar-footer { padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
        .user-avatar { 
            width: 40px; height: 40px; border-radius: 50%; 
            background: rgba(255,255,255,0.2); color: white; 
            font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: center; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .user-name { color: white; font-size: 14px; font-weight: 600; }
        .user-role { color: rgba(255,255,255,0.6); font-size: 11px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .btn-signout { 
            width: 100%; padding: 10px; 
            background: rgba(255,255,255,0.1); color: white; 
            border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; 
            font-size: 13px; font-weight: 600; cursor: pointer; 
            text-align: center; text-decoration: none; display: block; 
            transition: all 0.2s ease;
        }
        .btn-signout:hover { background: rgba(255,255,255,0.2); transform: translateY(-1px); }
        
        .main { margin-left: 250px; flex: 1; min-height: 100vh; padding: 40px; }

        /* Premium Global Elements */
        .topbar { background: white; padding: 20px 32px; display: flex; justify-content: space-between; align-items: center; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 32px; }
        .topbar-title h1 { font-size: 22px; font-weight: 800; color: #1a1a1a; letter-spacing: -0.5px; }
        .topbar-title p { font-size: 14px; color: #666; margin-top: 4px; }
        .date-badge { font-size: 13px; font-weight: 600; color: #cc0000; background: #fff0f0; padding: 8px 16px; border-radius: 20px; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px; }
        .stat-card { background: white; border-radius: 20px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.06); }
        .stat-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
        .stat-icon.red { background: linear-gradient(135deg, #fff0f0, #ffe5e5); color: #cc0000; }
        .stat-icon.blue { background: linear-gradient(135deg, #f0f4ff, #e5edff); color: #2563eb; }
        .stat-icon.yellow { background: linear-gradient(135deg, #fffbf0, #fff4cc); color: #d97706; }
        .stat-icon.green { background: linear-gradient(135deg, #f0fff4, #dcfce7); color: #16a34a; }
        .stat-info { flex: 1; }
        .stat-value { font-size: 28px; font-weight: 800; color: #1a1a1a; line-height: 1; margin-bottom: 6px; letter-spacing: -0.5px; }
        .stat-label { font-size: 14px; color: #666; font-weight: 500; }

        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .section-title { font-size: 18px; font-weight: 800; color: #1a1a1a; letter-spacing: -0.3px; }
        .section-sub { font-size: 14px; color: #666; margin-top: 4px; }
        .search-input { padding: 10px 18px; border-radius: 12px; border: 1px solid #e5e7eb; outline: none; font-size: 14px; width: 280px; font-family: inherit; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .search-input:focus { border-color: #cc0000; box-shadow: 0 0 0 3px rgba(204,0,0,0.1); }

        .table-card { background: white; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden; border: 1px solid rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        thead { background: #f8f9fb; border-bottom: 1px solid #f1f5f9; }
        th { padding: 16px 24px; text-align: left; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 16px 24px; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }

        .donor-cell { display: flex; align-items: center; gap: 12px; }
        .donor-avatar { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #cc0000, #ff6666); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(204,0,0,0.2); }
        .donor-name { font-weight: 600; color: #1e293b; font-size: 14px; }
        .donor-email { font-size: 12px; color: #64748b; margin-top: 2px; }

        .badge { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge-pending { background: #fffbf0; color: #d97706; }
        .badge-approved, .badge-fulfilled { background: #f0fff4; color: #16a34a; }
        .badge-rejected { background: #fff0f0; color: #dc2626; }

        .status-select { padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; color: #334155; background: white; cursor: pointer; outline: none; transition: all 0.2s; font-family: inherit; font-weight: 500; }
        .status-select:focus { border-color: #cc0000; box-shadow: 0 0 0 3px rgba(204,0,0,0.1); }
        .update-btn { padding: 8px 16px; background: #cc0000; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-family: inherit; }
        .update-btn:hover { background: #b30000; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(204,0,0,0.2); }

        .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
        .empty-state .icon { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
        .empty-state p { font-size: 15px; font-weight: 500; }

        .alert-success { background: #f0fff4; border: 1px solid #bbf7d0; color: #16a34a; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 10px rgba(22,163,74,0.1); }
        .alert-error { background: #fff0f0; border: 1px solid #fecaca; color: #dc2626; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 10px rgba(220,38,38,0.1); }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-name">🩸 BloodDonate</div>
            <div class="brand-sub">Management System</div>
        </div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.donors') }}" class="nav-item {{ request()->routeIs('admin.donors') ? 'active' : '' }}">
                <span class="icon">👥</span> Donors
            </a>
            <a href="{{ route('admin.requests.index') }}" class="nav-item {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
                <span class="icon">🩸</span> Blood Requests
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="nav-item {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
           <span class="icon">🩸</span> Blood Inventory
         </a>
         <a href="{{ route('admin.donations.create') }}" class="nav-item {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                    <span class="icon">🩸</span> Record Donation
                </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="s ubmit" class="btn-signout">⏻ Sign Out</button>
            </form>
        </div>
    </aside>
    <main class="main">
        @yield('content')
    </main>
</body>
</html>