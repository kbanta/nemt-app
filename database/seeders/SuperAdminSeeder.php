<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadminthumbstack@gmail.com'],
            [
                'name'     => 'SuperAdmin',
                'password' => Hash::make('password'),
                'role'     => 'superadmin',
                'phone'    => '09361336825',
            ]
        );
    }
}