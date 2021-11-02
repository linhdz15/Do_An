<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@vietjack.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin@123'),
                'status' => 1,
                'role' => 1,
                'email_verified_at' => now()
            ]
        );
    }
}
