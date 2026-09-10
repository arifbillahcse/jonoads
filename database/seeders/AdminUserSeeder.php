<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Credentials come from the environment so no password is committed.
        // Set ADMIN_EMAIL and ADMIN_PASSWORD before seeding in production.
        $email = env('ADMIN_EMAIL', 'admin@jonoads.com');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Jono Admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'role' => UserRole::Admin,
            ],
        );
    }
}
