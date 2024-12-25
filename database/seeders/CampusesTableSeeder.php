<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Campus::create([
            'campus_name' => 'Kemanggisan',
            'description' => 'Kampus Kemanggisan',
            'minimum_semester' => null, // Nullable
            'created_by' => 'CampusesTableSeeder' ,
            'updated_by' => null,
        ]);

        Campus::create([
            'campus_name' => 'Alam Sutera',
            'description' => 'Kampus Alam Sutera',
            'minimum_semester' => null, // Nullable
            'created_by' => 'CampusesTableSeeder' ,
            'updated_by' => null,
        ]);

        
    }
}
