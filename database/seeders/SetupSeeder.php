<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SetupSeeder extends Seeder
{
    public function run(): void
    {
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
    }
}
