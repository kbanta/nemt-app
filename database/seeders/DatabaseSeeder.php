<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Driver;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@nemt.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '555-0001',
        ]);

        // Client
        $client = User::create([
            'name'     => 'Jane Patient',
            'email'    => 'client@nemt.com',
            'password' => Hash::make('password'),
            'role'     => 'client',
            'phone'    => '555-0002',
        ]);

        // Driver
        $driverUser = User::create([
            'name'     => 'John Driver',
            'email'    => 'driver@nemt.com',
            'password' => Hash::make('password'),
            'role'     => 'driver',
            'phone'    => '555-0003',
        ]);

        Driver::create([
            'user_id'        => $driverUser->id,
            'license_number' => 'DL-123456',
            'license_expiry' => '2027-01-01',
            'status'         => 'approved',
            'is_available'   => true,
        ]);

        // Service Types
        $services = [
            ['name' => 'Ambulatory Transport',  'description' => 'For patients who can walk but need assistance.', 'base_price' => 25.00, 'price_per_mile' => 2.50],
            ['name' => 'Wheelchair Transport',  'description' => 'Equipped vehicle for wheelchair users.',         'base_price' => 40.00, 'price_per_mile' => 3.00],
            ['name' => 'Stretcher Transport',   'description' => 'For patients who must remain lying down.',       'base_price' => 75.00, 'price_per_mile' => 4.50],
            ['name' => 'Bariatric Transport',   'description' => 'Specially equipped for bariatric patients.',     'base_price' => 90.00, 'price_per_mile' => 5.00],
            ['name' => 'Gurney Transport',      'description' => 'Non-emergency gurney transportation.',           'base_price' => 80.00, 'price_per_mile' => 4.00],
        ];

        foreach ($services as $s) {
            ServiceType::create(array_merge($s, ['is_active' => true]));
        }
    }
}