<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('kupal12345'),
                'role' => 'admin',
                'contact' => '09123456789',
                'address' => '123 Main St, Dagupan City',
                'account_status' => 'active_admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Recipient User',
                'email' => 'recipient@gmail.com',
                'password' => Hash::make('kupal12345'),
                'role' => 'recipient',
                'contact' => '09123456789',
                'address' => '123 Main St, Dagupan City',
                'account_status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Donor User',
                'email' => 'donor@gmail.com',
                'password' => Hash::make('kupal12345'),
                'role' => 'donor',
                'contact' => '09123456789',
                'address' => '123 Main St, Dagupan City',
                'account_status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'name' => 'IT Staff User',
                'email' => 'itstaff@gmail.com',
                'password' => Hash::make('kupal12345'),
                'role' => 'it_staff',
                'contact' => '09123456789',
                'address' => '123 Main St, Dagupan City',
                'account_status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'name' => 'CSDL Staff User',
                'email' => 'csdlstaff@gmail.com',
                'password' => Hash::make('kupal12345'),
                'role' => 'csdl_staff',
                'contact' => '09123456789',
                'address' => '123 Main St, Dagupan City',
                'account_status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'name' => 'Monitoring Staff User',
                'email' => 'monitoringstaff@gmail.com',
                'password' => Hash::make('kupal12345'),
                'role' => 'monitoring_staff',
                'contact' => '09123456789',
                'address' => '123 Main St, Dagupan City',
                'account_status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
