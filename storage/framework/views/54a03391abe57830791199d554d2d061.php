<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Blood Donation System')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <style>
            body {
                font-family: 'Inter', sans-serif !important;
                background: linear-gradient(135deg, #4a0000 0%, #800000 40%, #cc0000 100%);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                margin: 0;
                position: relative;
                overflow: hidden;
            }

            body::before {
                content: ''; position: absolute; top: -15%; left: -10%;
                width: 50vw; height: 50vw; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 60%); border-radius: 50%; z-index: 0; pointer-events: none;
            }
            body::after {
                content: ''; position: absolute; bottom: -15%; right: -10%;
                width: 60vw; height: 60vw; background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 60%); border-radius: 50%; z-index: 0; pointer-events: none;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.4);
                border-radius: 24px;
                padding: 48px 40px;
                width: 90%;
                max-width: 420px;
                box-shadow: 0 24px 48px rgba(0, 0, 0, 0.3);
                position: relative;
                z-index: 10;
            }

            .logo-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-bottom: 32px;
            }
            
            .logo-icon {
                font-size: 56px;
                line-height: 1;
                margin-bottom: 12px;
                filter: drop-shadow(0 8px 16px rgba(204,0,0,0.3));
                animation: float 3s ease-in-out infinite;
            }
            
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
                100% { transform: translateY(0px); }
            }

            .logo-text {
                font-size: 26px;
                font-weight: 900;
                color: #cc0000;
                letter-spacing: -0.5px;
            }
            .logo-sub {
                font-size: 13px;
                color: #64748b;
                font-weight: 600;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                margin-top: 4px;
            }

            /* Breeze Form Overrides */
            input[type="email"], input[type="password"], input[type="text"] {
                border-radius: 12px !important;
                border: 1.5px solid #e2e8f0 !important;
                padding: 14px 16px !important;
                font-size: 14px !important;
                font-family: 'Inter', sans-serif !important;
                font-weight: 500 !important;
                color: #1e293b !important;
                transition: all 0.2s !important;
                box-shadow: none !important;
                background-color: #f8fafc !important;
            }
            
            input[type="email"]:focus, input[type="password"]:focus, input[type="text"]:focus {
                border-color: #cc0000 !important;
                box-shadow: 0 0 0 4px rgba(204,0,0,0.1) !important;
                background-color: #ffffff !important;
            }
            
            label {
                font-size: 13px !important;
                font-weight: 700 !important;
                color: #334155 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                margin-bottom: 6px !important;
            }

            .flex.items-center.justify-end.mt-4 {
                flex-direction: column;
                gap: 16px;
                margin-top: 24px !important;
            }

            button[type="submit"] {
                background: linear-gradient(135deg, #7a0000, #cc0000) !important;
                border-radius: 12px !important;
                padding: 14px 24px !important;
                font-size: 15px !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                letter-spacing: 1px !important;
                border: none !important;
                transition: all 0.2s !important;
                box-shadow: 0 4px 15px rgba(204,0,0,0.2) !important;
                width: 100% !important;
                justify-content: center !important;
                margin: 0 !important;
            }
            
            button[type="submit"]:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 8px 20px rgba(204,0,0,0.3) !important;
            }

            a.underline {
                color: #64748b !important;
                font-weight: 600 !important;
                text-decoration: none !important;
                transition: color 0.2s !important;
            }
            a.underline:hover {
                color: #cc0000 !important;
            }

            .text-indigo-600 { color: #cc0000 !important; }
            .focus\:ring-indigo-500:focus { --tw-ring-color: #cc0000 !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900">
        
        <div class="glass-card">
            <div class="logo-container">
                <div class="logo-icon">🩸</div>
                <div class="logo-text">BloodDonate</div>
                <div class="logo-sub">Management System</div>
            </div>

            <div class="w-full mt-2">
                <?php echo e($slot); ?>

            </div>
        </div>

    </body>
</html>
<?php /**PATH C:\laravel\blood_donation_system\resources\views/layouts/guest.blade.php ENDPATH**/ ?>