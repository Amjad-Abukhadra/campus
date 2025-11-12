<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Student $i",
                'email' => "student$i@example.com",
                'password' => bcrypt('password123'), 
            ]);
            $user->addRole('student');
        }
    }
}
