<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call other seeders here
        $this->call([
            UsersTableSeeder::class,
            CampusesTableSeeder::class,
            CampusProgressTableSeeder::class,
            RoomTableSeeder::class,
            CharacterTableSeeder::class,
            QuestActivityTableSeeder::class,
            QuestProgressTableSeeder::class,
            ActivityProgressTableSeeder::class,
            ActivitySceneSeeder1::class, // Intro Dialogue
            ActivitySceneSeeder2::class, // Story Case
            ActivitySceneSeeder3::class, // More Dialogues
            ActivitySceneSeeder4::class, // Drum Puzzle
            ActivitySceneSeeder5::class, // Stage
            ActivitySceneSeeder6::class, // Crossword
        ]);
    }
}
