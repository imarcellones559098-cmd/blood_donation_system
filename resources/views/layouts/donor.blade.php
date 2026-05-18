<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; }
        
        .premium-nav {
            background: linear-gradient(90deg, rgba(139,0,0,0.95), rgba(204,0,0,0.9));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: sticky; top: 0; z-index: 50;
        }

        .nav-link {
            position: relative;
            padding: 8px 12px;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            font-weight: 600;
        }
        
        .nav-btn {
            transition: all 0.2s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .nav-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        /* --- Global Premium Classes --- */
        .page-wrapper { max-width: 1000px; margin: 0 auto; padding: 32px 24px; font-family: 'Inter', sans-serif; }
        
        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
        .stat-card { background: white; border-radius: 20px; padding: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.06); }
        .stat-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
        .stat-icon.red { background: linear-gradient(135deg, #fff0f0, #ffe5e5); color: #cc0000; }
        .stat-icon.blue { background: linear-gradient(135deg, #f0f4ff, #e5edff); color: #2563eb; }
        .stat-icon.yellow { background: linear-gradient(135deg, #fffbf0, #fff4cc); color: #d97706; }
        .stat-icon.green { background: linear-gradient(135deg, #f0fff4, #dcfce7); color: #16a34a; }
        .stat-info { flex: 1; }
        .stat-value { font-size: 28px; font-weight: 800; color: #1a1a1a; line-height: 1; margin-bottom: 6px; letter-spacing: -0.5px; }
        .stat-label { font-size: 14px; color: #64748b; font-weight: 500; }

        /* Tables */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .section-title { font-size: 18px; font-weight: 800; color: #1a1a1a; letter-spacing: -0.3px; }
        .section-sub { font-size: 14px; color: #64748b; margin-top: 4px; }
        .table-card { background: white; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden; border: 1px solid rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        thead { background: #f8f9fb; border-bottom: 1px solid #f1f5f9; }
        th { padding: 16px 24px; text-align: left; font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 16px 24px; color: #334155; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8fafc; }

        /* Badges */
        .badge { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
        .badge-pending { background: #fffbf0; color: #d97706; }
        .badge-approved { background: #f0fff4; color: #16a34a; }
        .badge-fulfilled { background: #f0fff4; color: #16a34a; }
        .badge-rejected { background: #fff0f0; color: #dc2626; }
        
        .alert-success { background: #f0fff4; border: 1px solid #bbf7d0; color: #16a34a; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 10px rgba(22,163,74,0.1); }
        .alert-error { background: #fff0f0; border: 1px solid #fecaca; color: #dc2626; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 10px rgba(220,38,38,0.1); }
        
        .search-input { padding: 10px 18px; border-radius: 12px; border: 1px solid #e5e7eb; outline: none; font-size: 14px; width: 280px; font-family: inherit; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .search-input:focus { border-color: #cc0000; box-shadow: 0 0 0 3px rgba(204,0,0,0.1); }
        
        .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
        .empty-state .icon { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
        .empty-state p { font-size: 15px; font-weight: 500; }
    </style>
</head>
<body class="min-h-screen text-gray-800">

    <!-- Navbar -->
    <nav class="premium-nav text-white">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('donor.dashboard') }}" class="flex items-center gap-2 font-extrabold text-xl tracking-tight">
                <span class="text-2xl drop-shadow-md">🩸</span> BloodDonate
            </a>
            <div class="flex items-center gap-2 text-sm font-medium">
                <a href="{{ route('donor.dashboard') }}"
                   class="nav-link {{ request()->routeIs('donor.dashboard') ? 'active' : 'text-red-100' }}">
                    Dashboard
                </a>
                 <a href="{{ route('donor.requests.index') }}"
                    class="nav-link {{ request()->routeIs('donor.requests.*') ? 'active' : 'text-red-100' }}">
                    Blood Requests
                </a>
                <a href="{{ route('donor.profile') }}"
                   class="nav-link {{ request()->routeIs('donor.profile') ? 'active' : 'text-red-100' }}">
                    My Profile
                </a>
                <form action="{{ route('logout') }}" method="POST" class="ml-4">
                    @csrf
                    <button type="submit"
                            class="nav-btn bg-white text-red-700 px-4 py-2 rounded-lg font-bold hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 border border-green-300">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6 border border-red-300">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-gray-400 text-xs py-6 mt-10 border-t">
        &copy; {{ date('Y') }} Blood Donation Management System. All rights reserved.
    </footer>

</body></html>