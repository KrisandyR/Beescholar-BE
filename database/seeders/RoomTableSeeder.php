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
                    'room_name' => 'Class Room',
                    'type' => "Interactible",
                    'background' => 'dummy-classroom.jpeg',
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Band Room',
                    'background' => 'band_room_empty.png',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Teacher Office',
                    'background' => 'dummy-classroom.jpeg',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Hallway',
                    'background' => 'dummy-classroom.jpeg',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);
            }

            if($campus->campus_name == 'Alam Sutera'){
                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Class Room',
                    'background' => 'dummy-classroom.jpeg',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Hallway',
                    'background' => 'dummy-classroom.jpeg',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Campus Field',
                    'background' => 'dummy-classroom.jpeg',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);

                Room::create([
                    'campus_id' => $campus->id,
                    'room_name' => 'Multimedia Room',
                    'background' => 'dummy-classroom.jpeg',
                    'type' => "Interactible",
                    'created_by' => 'RoomTableSeeder',
                    'updated_by' => null,
                ]);
            }

        }


    }
}
