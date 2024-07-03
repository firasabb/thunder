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

            $teams = Team::where('status', 'active');
        }
        else {
            // get the teams where the conferences are not acc, big12, big10, sec
            $teams = Team::where('status', 'active')->whereHas('conferences', function($query){
                $query->where('abbreviation', 'PAC');
            });
        }

        $teams = $teams->orderBy('name')->get();

        return response()->json($teams);
    }
}
