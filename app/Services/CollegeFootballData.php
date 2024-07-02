<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Conference;
use App\Models\Team;

class CollegeFootballData{


    /**
     * Get a list of teams from the College Football Data API
     * 
     * @param string $conference
     * @return string|null
     */
    public static function getTeams($conference = ''){
        
        $apiKey = config('services.college_football_data.api_key');
        $baseUrl = config('services.college_football_data.base_url');
        $url = $baseUrl . '/teams';

        if($conference){
            $url .= '?conference=' . $conference;
        }

        $result = Http::withToken($apiKey)->get($url);

        if($result->successful()){
            return $result->json();
        }

        return null;
    }


    /**
     * 
     * Create a json file of teams from the College Football Data API
     * @return bool
     * 
     */
    public static function createTeamsJsonFile($conference = ''){

        $teams = self::getTeams($conference);

        if($teams){
            $teams = json_encode($teams, JSON_PRETTY_PRINT);
            Storage::disk('public')->put('teams.json', $teams);
            return true;
        }

        return false;
    }


    /**
     * 
     * Get conferences from the College Football Data API
     * @return string|null
     * 
     */
    public static function getConferences(){

        $apiKey = config('services.college_football_data.api_key');
        $baseUrl = config('services.college_football_data.base_url');
        $url = $baseUrl . '/conferences';

        $result = Http::withToken($apiKey)->get($url);

        if($result->successful()){
            return $result->json();
        }
        return null;
    }


    /**
     * 
     * Create a json file of conferences from the College Football Data API
     * @return bool
     * 
     */
    public static function createConferencesJsonFile(){

        $conferences = self::getConferences();

        if($conferences){
            $conferences = json_encode($conferences, JSON_PRETTY_PRINT);
            Storage::disk('public')->put('conferences.json', $conferences);
            return true;
        }

        return false;
    }


    

    /**
     * 
     * Read from ESPN API
     * 
     */
    public static function getEspnTeamsAndConferences(){

        $url = 'https://site.web.api.espn.com/apis/v2/sports/football/college-football/standings?region=us&lang=en&contentorigin=espn&group=80&level=3&sort=leaguewinpercent%3Adesc%2Cvsconf_wins%3Adesc%2Cvsconf_gamesbehind%3Aasc%2Cvsconf_playoffseed%3Aasc%2Cwins%3Adesc%2Closses%3Adesc%2Cplayoffseed%3Aasc%2Calpha%3Aasc&startingseason=2004';

        $result = Http::get($url);

        // read json, loop through 'children', standings, entries, team
        $conferences = $result->json()['children'];

        foreach($conferences as $conferenceJson){

            switch($conferenceJson['name']){
                case 'Atlantic Coast Conference':
                    $conference = Conference::where('abbreviation', 'ACC')->first();
                    break;
                case 'Big 12 Conference':
                    $conference = Conference::where('abbreviation', 'B12')->first();
                    break;
                case 'Big Ten Conference':
                    $conference = Conference::where('abbreviation', 'B1G')->first();
                    break;
                case 'Southeastern Conference':
                    $conference = Conference::where('abbreviation', 'SEC')->first();
                    break;
                default:
                    // put the default conference as PAC-12 for now
                    $conference = Conference::where('abbreviation', 'PAC')->first();
                    break;
            }

            
            if(isset($conferenceJson['children'])){
                foreach($conferenceJson['children'] as $division){
                    foreach($division['standings']['entries'] as $team){
                        // find the team from the database and update the conference_id
                        $dbTeam = Team::where('abbreviation', $team['team']['abbreviation'])->first();
                        if($dbTeam){
                            $dbTeam->conferences()->sync($conference->id);
                        }
                    }
                }
            } else {
                foreach($conferenceJson['standings']['entries'] as $team){
                    // find the team from the database and update the conference_id
                    $dbTeam = Team::where('abbreviation', $team['team']['abbreviation'])->first();
                    if($dbTeam){
                        $dbTeam->conferences()->sync($conference->id);
                    }
                }
            }
        }
    }

}