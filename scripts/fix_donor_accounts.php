<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::updateOrCreate(
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
        'password' => Hash::make('donor123'),
        'role' => 'donor',
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

echo "Admin and donor accounts updated:\n";
echo "- admin@blood.com => admin123\n";
echo "- donor1@blood.com => donor123\n";
echo "- donor2@blood.com => donor123\n";
echo "- donor3@blood.com => donor123\n";
