<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conference;
use App\Models\Team;

class TeamController extends Controller
{
    public function getConferenceTeams($conference = '')
    {

        $teams = [];
        if($conference && $conference != 'all'){

            $conference = Conference::where('abbreviation', $conference)->firstOrFail();
            $teams = $conference->teams();

        } else if($conference == 'all'){

            $teams = Team::whereHas('conferences', function($query){
                $query->whereIn('abbreviation', ['ACC', 'B12', 'B1G', 'SEC', 'PAC']);
            });

        }
        else {
            // get the teams where the conferences are not acc, big12, big10, sec
            $teams = Team::whereHas('conferences', function($query){
                $query->where('abbreviation', 'PAC');
            })->whereNotIn('id', [184, 768, 562]);
        }

        $teams = $teams->orderBy('name')->get();

        // remove duplicates
        $teams = $teams->unique('uuid');

        return response()->json($teams);
    }
}
