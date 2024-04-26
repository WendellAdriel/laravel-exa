<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\User;
use Modules\Auth\Support\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@example.com')->first();

        if ($user) {
            $user->update([
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => Role::ADMIN->value,
            ]);
        } else {
            User::create([
                'email' => 'admin@example.com',
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => Role::ADMIN->value,
            ]);
        }
    }
}
