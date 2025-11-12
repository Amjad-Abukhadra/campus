<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        Role::firstOrCreate(['name' => 'admin', 'display_name' => 'Administrator']);
        Role::firstOrCreate(['name' => 'landlord', 'display_name' => 'Landlord']);
        Role::firstOrCreate(['name' => 'student', 'display_name' => 'Student']);
    }
}
