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
        //
        // env()'s default only applies when the key is entirely absent — a
        // blank ADMIN_PASSWORD= in .env still counts as "set" and would seed
        // an empty password, so an empty string is treated as unset here too.
        $email = env('ADMIN_EMAIL');
        $email = $email === null || $email === '' ? 'admin@jonoads.com' : $email;

        $password = env('ADMIN_PASSWORD');
        $password = $password === null || $password === '' ? 'password' : $password;

        $name = env('ADMIN_NAME');
        $name = $name === null || $name === '' ? 'Jono Admin' : $name;

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => UserRole::Admin,
            ],
        );
    }
}
