<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! User::query()->where('email', 'admin@email.com')
            ->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => Hash::make('S8perpass1.'),
            ]);
        }
    }
}
