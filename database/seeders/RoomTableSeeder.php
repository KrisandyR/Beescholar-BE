<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $campuses = Campus::all();

        if($campuses->isEmpty()){
            $this->command->warn('Empty campuses');
        }

        foreach($campuses as $campus){

            if($campus->campus_name == 'Kemanggisan'){
                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Classroom',
                    'type' => "Interactible",
                    'background' => '/backgrounds/Classroom.png',
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Band Room',
                    'background' => '/backgrounds/Band-Room.png',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Teacher Office',
                    'background' => '/backgrounds/Teacher-Office.png',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Hallway',
                    'background' => '/backgrounds/Hallway.png',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);
            }

            if($campus->campus_name == 'Alam Sutera'){
                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Classroom',
                    'background' => '/backgrounds/Classroom.png',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Hallway',
                    'background' => '/backgrounds/Hallway.png',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Campus Field',
                    'background' => '/backgrounds/Campus-Field.png',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Multimedia Room',
                    'background' => '/backgrounds/Multimedia-Room.pmg',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);
            }

        }


    }
}
