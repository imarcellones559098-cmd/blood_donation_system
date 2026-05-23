<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DonorSeeder extends Seeder
{
    public function run(): void
    {
        $donors = [
            [
                'name' => 'Reymond Marcellones',
                'email' => 'reymondmarcellones@gmail.com',
                'password' => 'donor123',
            ],
            [
                'name' => 'Jon',
                'email' => 'jon@gmail.com',
                'password' => 'donor123',
            ],
            [
                'name' => 'Ian Ray',
                'email' => 'ianray@gmail.com',
                'password' => 'donor123',
            ],
            [
                'name' => 'Grace',
                'email' => 'grace@gmail.com',
                'password' => 'donor123',
            ],
            [
                'name' => 'Mhea',
                'email' => 'mhea@gmail.com',
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
