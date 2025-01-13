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
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
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
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);

        // fake leaderboar data
        User::create([
            'name' => 'Casey Trujillo',
            'role' => 'Student',
            'user_code' => '2502045363',
            'academic_career' => 'RS1',
            'total_point' => 300,
            'completion_date' => '2024-09-05 06:50:13',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045363@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Elaine Johnson',
            'role' => 'Student',
            'user_code' => '2502045364',
            'academic_career' => 'RS1',
            'total_point' => 500,
            'completion_date' => '2024-09-23 04:29:51',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045364@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Sharon Hogan',
            'role' => 'Student',
            'user_code' => '2502045365',
            'academic_career' => 'RS1',
            'total_point' => 450,
            'completion_date' => '2024-01-04 01:11:12',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045365@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Eric Jackson',
            'role' => 'Student',
            'user_code' => '2502045366',
            'academic_career' => 'RS1',
            'total_point' => 350,
            'completion_date' => '2024-01-06 07:42:28',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045366@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Janice Lynch',
            'role' => 'Student',
            'user_code' => '2502045367',
            'academic_career' => 'RS1',
            'total_point' => 300,
            'completion_date' => '2024-08-17 10:51:34',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045367@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Traci Copeland MD',
            'role' => 'Student',
            'user_code' => '2502045368',
            'academic_career' => 'RS1',
            'total_point' => 2500,
            'completion_date' => '2024-05-01 18:55:21',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045368@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Kyle Chaney',
            'role' => 'Student',
            'user_code' => '2502045369',
            'academic_career' => 'RS1',
            'total_point' => 1500,
            'completion_date' => '2024-05-21 19:00:16',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045369@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Donna Marks',
            'role' => 'Student',
            'user_code' => '2502045370',
            'academic_career' => 'RS1',
            'total_point' => 1500,
            'completion_date' => '2024-07-03 20:15:28',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045370@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Jonathan Grant',
            'role' => 'Student',
            'user_code' => '2502045371',
            'academic_career' => 'RS1',
            'total_point' => 200,
            'completion_date' => '2024-11-21 01:41:31',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045371@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
        
        User::create([
            'name' => 'Sandra Crawford',
            'role' => 'Student',
            'user_code' => '2502045372',
            'academic_career' => 'RS1',
            'total_point' => 200,
            'completion_date' => '2024-06-20 19:21:24',
            'semester' => 7,
            'gender' => 'M',
            'email' => '2502045372@example.com',
            'password' => bcrypt('a'),
            'profile_picture' => 'https://avatar.iran.liara.run/public',
            'created_by' => 'UsersTableSeeder',
            'updated_by' => null,
        ]);
    }
}
