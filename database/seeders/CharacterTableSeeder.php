<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\Character;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Console\RouteClearCommand;

class CharacterTableSeeder extends Seeder
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

        $kemanggisan_characters = [
            [
                'character_name' => 'Diyan',
                'character_image' => '/characters/Diyan.png',
                'roles' => ['Teacher'],
                'description' => 'Diyan, the seasoned teacher, wears tweed jackets and encourages curiosity in young minds.',
                'gender' => 'M',
                'likes' => ['Vintage chalkboards', 'Classic literature', 'Mentoring students'],
                'dislikes' => ['Bureaucracy', 'Standardized testing', 'Fluorescent lighting'],
            ],
            [
                'character_name' => 'Ehan',
                'character_image' => '/characters/Ehan.png',
                'roles' => ['Student', 'Best Friend', 'Member of the Band Club', 'Guitarist'],
                'description' => 'Ehan, the aspiring musician, wears faded band T-shirts and dreams of performing on a big stage.',
                'gender' => 'M',
                'likes' => ['Indie music', 'Late-night jam sessions', 'Vintage guitars'],
                'dislikes' => ['Early mornings', 'Rigid rules', 'Cafeteria food'],
            ],
            [
                'character_name' => 'Agatha',
                'character_image' => '/characters/Agatha.png',
                'roles' => ['Student', 'Leader of the School’s News Club'],
                'description' => 'Agatha, the news editor, wears oversized glasses and carries a notepad wherever she goes.',
                'gender' => 'F',
                'likes' => ['Investigative journalism', 'Old typewriters', 'Hidden secrets'],
                'dislikes' => ['Sensationalism', 'Shallow conversations', 'Biased reporting'],
            ],
            [
                'character_name' => 'Agung',
                'character_image' => '/characters/Agung.png',
                'roles' => ['Student', 'Class Leader'],
                'description' => 'Agung, the class leader, balances authority with compassion, ensuring everyone’s voice is heard.',
                'gender' => 'M',
                'likes' => ['Organizing events', 'Public speaking', 'Problem-solving'],
                'dislikes' => ['Chaos', 'Tardiness', 'Unfairness'],
            ],
            [
                'character_name' => 'Rico',
                'character_image' => '/characters/Rico.png',
                'roles' => ['Student', 'Member of the Band Club', 'Drummer'],
                'description' => 'Rico, the heartbeat of the band, wears mismatched socks and dreams of touring the world.',
                'gender' => 'M',
                'likes' => ['Vintage vinyl records', 'Rhythm games', 'Impromptu drum solos'],
                'dislikes' => ['Silence', 'Empty stages', 'Broken drumsticks'],
            ],
            [
                'character_name' => 'Markus',
                'character_image' => '/characters/Markus.png',
                'roles' => ['Student'],
                'description' => 'Markus, the bookworm, seeks answers beyond the syllabus.',
                'gender' => 'M',
                'likes' => ['Rare books', 'Crossword puzzles', 'Philosophical debates'],
                'dislikes' => ['Noise pollution', 'Shallow conversations', 'Cafeteria pizza'],
            ],
            [
                'character_name' => 'Ania',
                'character_image' => '/characters/Ania.png',
                'roles' => ['Student', 'Twins with Enia'],
                'description' => 'Ania, the poet, weaves verses about love and longing.',
                'gender' => 'F',
                'likes' => ['Vintage postcards', 'Handwritten letters', 'Rainy afternoons'],
                'dislikes' => ['Digital distractions', 'Crowded buses', 'Broken promises'],
            ],
            [
                'character_name' => 'Enia',
                'character_image' => '/characters/Enia.png',
                'roles' => ['Student', 'Twins with Ania'],
                'description' => 'Enia, the stargazer, believes that every star has a story to tell.',
                'gender' => 'F',
                'likes' => ['Sunflowers', 'Classical music', 'Astronomy'],
                'dislikes' => ['Harsh fluorescent lights', 'Rushed mornings', 'Insincerity'],
            ],
            [
                'character_name' => 'Diana',
                'character_image' => '/characters/Diana.png',
                'roles' => ['Student', 'Member of the Band Club', 'Singer'],
                'description' => 'Diana, the lead vocalist, wears her heart on her sleeve and dreams of recording an album.',
                'gender' => 'F',
                'likes' => ['Melodic poetry', 'Vintage microphones', 'Stage lights'],
                'dislikes' => ['Off-key singing', 'Empty concert halls', 'Forgotten lyrics'],
            ],
        ];

        $as_characters = [
            [
                'character_name' => 'Adhi',
                'character_image' => '/characters/Adhi.png',
                'roles' => ['Beescholar’s Late President', 'Strict but Friendly'],
                'description' => 'Adhi, the former Beescholar president, balanced responsibilities with a warm smile.',
                'gender' => 'M',
                'likes' => ['Ancient manuscripts', 'Well-structured meetings', 'Mentoring younger Beescholars'],
                'dislikes' => ['Procrastination', 'Inefficiency', 'Empty promises'],
            ],
            [
                'character_name' => 'Tifa',
                'character_image' => '/characters/Tifa.png',
                'roles' => ['Beescholar’s Late Vice President'],
                'description' => 'Tifa, the former Beescholar VP, believed in unity and consensus.',
                'gender' => 'F',
                'likes' => ['Collaborative projects', 'Brainstorming sessions', 'Diplomatic negotiations'],
                'dislikes' => ['Disorganization', 'Conflicts', 'Missed deadlines'],
            ],
            [
                'character_name' => 'Rektor',
                'character_image' => '/characters/Rektor.png',
                'roles' => ['Headmaster'],
                'description' => 'Rektor, the stern but respected headmaster, ensured discipline and upheld the institution’s legacy.',
                'gender' => 'M',
                'likes' => ['Academic excellence', 'Tradition', 'Maintaining school reputation'],
                'dislikes' => ['Rule violations', 'Disruptions', 'Favoritism'],
            ],
        ];

        foreach($campuses as $campus){
            $campusCharacters = [
                'Kemanggisan' => $kemanggisan_characters,
                'Alam Sutera' => $as_characters,
            ];
        
            // Check if the campus name exists in the defined group
            if (array_key_exists($campus->campus_name, $campusCharacters)) {
                foreach ($campusCharacters[$campus->campus_name] as $character) {
                    Character::create([
                        'campus_id' => $campus->id,
                        'character_name' => $character['character_name'],
                        'character_image' => $character['character_image'],
                        'roles' => $character['roles'],
                        'description' => $character['description'],
                        'gender' => $character['gender'],
                        'likes' => $character['likes'],
                        'dislikes' => $character['dislikes'],
                        'created_by' => 'CharacterTableSeeder',
                        'updated_by' => null,
                    ]);
                }
            }
        }

        // Create main character placeholder
        Character::create([
            'campus_id' => null,
            'character_name' => '[MC]',
            'character_image' => '/characters/MC.png',
            'roles' => ['The New Beescholar Member'],
            'description' => '[MC], the newest member of Beescholar, is eager to prove their worth and discover their role in the campus community.',
            'gender' => '-',
            'likes' => ['Learning new skills', 'Helping others', 'Exploring new opportunities'],
            'dislikes' => ['Unfair treatment', 'Closed-mindedness', 'Lack of transparency'],
            'created_by' => 'CharacterTableSeeder',
            'updated_by' => null,
        ]);


    }

    /*

    -- Kemanggisan --
    Diyan
    Ehan
    Agatha
    Agung
    Rico
    Markus
    Ania
    Enia

    -- Semarang --
    Edith 
    Eve
    Sekar

    -- Bandung --
    Wade
    Nathan
    Adrian

    -- Bekasi --
    Collata
    Scott
    Wanda

    -- Malang --
    Hansen
    Melody
    Vanya

    -- Alam Sutera --
    Adhi
    Tifa
    Rektor

    */
}
