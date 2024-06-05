<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Conference;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Read from teams.json file
        $teams = json_decode(file_get_contents(storage_path('json/teams.json')), true);
        
        foreach($teams as $team){

            $logo = isset($team['logos']) && count($team['logos']) ? $team['logos'][0] : null;
            $city = isset($team['location']) && isset($team['location']['city']) ? $team['location']['city'] : null;
            $state = isset($team['location']) && isset($team['location']['state']) ? $team['location']['state'] : null;

            $newTeam = Team::create([
                'name'          => $team['school'],
                'abbreviation'  => $team['abbreviation'],
                'logo_url'      => $logo,
                'city'          => $city,
                'state'         => $state,
            ]);

            if($logo){
                
                try{   
                    $newTeam->addMediaFromUrl($logo)->toMediaCollection('featured');
                } catch(\Exception $e){
                    echo $e->getMessage();
                }
                
                usleep(5000);
            }

            $conference = $team['conference'];

            if($conference){
                $conference = Conference::where('name', $conference)->first();
                if($conference){
                    $newTeam->conferences()->attach($conference->id);
                }
            }

            // read the file json/activeTeams.json
            $activeTeams = json_decode(file_get_contents(storage_path('json/activeTeams.json')), true);

            // check if the team is active
            foreach($activeTeams as $activeTeam){
                $activeTeam = trim($activeTeam);
                if($activeTeam == $team['abbreviation'] || $activeTeam == $team['school']){
                    $newTeam->status = 'active';
                    $newTeam->save();
                    break;
                }
            }
        }
    }
}
