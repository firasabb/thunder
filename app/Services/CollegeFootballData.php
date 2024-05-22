<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
}