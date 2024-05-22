<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Conference;

class ConferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Read from teams.json file
        $teams = json_decode(file_get_contents(storage_path('json/conferences.json')), true);
        
        foreach($teams as $team){
            Conference::create([
                'name'          => $team['name'],
                'abbreviation'  => $team['abbreviation']
            ]);
        }
    }
}
