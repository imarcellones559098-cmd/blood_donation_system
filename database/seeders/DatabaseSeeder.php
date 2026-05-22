<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        if (!User::where('email', 'admin@blood.com')->exists()) {
            User::factory()->create([
                'email' => 'admin@blood.com',
                'password' => bcrypt('admin123'),
            ]);
        }
    }
}
