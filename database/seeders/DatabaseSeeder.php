<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => 'Администратор',
            'email' => env('ADMIN_EMAIL', 'admin@example.com'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'ChangeMe!123')),
            'is_admin' => true,
        ]);

        $this->call(LandingSeeder::class);
        $this->call(SeoPagesSeeder::class);
    }
}
