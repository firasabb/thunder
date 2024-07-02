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
            $teams = $conference->teams()->orderBy('name')->get();

        } else if($conference == 'all'){

            $teams = Team::where('status', 'active')->has('conferences')->get();
        }
        else {
            $teams = Team::where('status', 'active')->get();
        }

        return response()->json($teams);
    }
}
