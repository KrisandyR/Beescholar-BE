<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::create([
            'name' => 'Krisandy Rivera',
            'role' => 'Student',
            'user_code' => '2502045361',
            'academic_career' => 'RS1',
            'semester' => 7,
            'gender' => 'M',
            'email' => 'krisandy.rivera@binus.ac.id',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);

        User::create([
            'name' => 'Dummy Student',
            'role' => 'Student',
            'user_code' => '2502045362',
            'academic_career' => 'RS1',
            'semester' => 7,
            'gender' => 'M',
            'email' => 'dummy.student01@binus.ac.id',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
    }
}
