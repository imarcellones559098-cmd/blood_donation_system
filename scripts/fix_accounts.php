<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

User::updateOrCreate(
    ['email' => 'admin@blood.com'],
    [
        'name' => 'Admin',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]
);

$donors = [
    [
        'name' => 'Donor One',
        'email' => 'donor1@blood.com',
        'password' => 'donor123',
    ],
    [
        'name' => 'Donor Two',
        'email' => 'donor2@blood.com',
        'password' => 'donor123',
    ],
    [
        'name' => 'Donor Three',
        'email' => 'donor3@blood.com',
        'password' => 'donor123',
    ],
];

foreach ($donors as $donor) {
    User::updateOrCreate(
        ['email' => $donor['email']],
        [
            'name' => $donor['name'],
            'password' => Hash::make($donor['password']),
            'role' => 'donor',
        ]
    );
}

echo "Admin and donor accounts updated.\n";
echo "Admin login: admin@blood.com / admin123\n";
echo "Donor logins: donor1@blood.com, donor2@blood.com, donor3@blood.com with password donor123\n";
