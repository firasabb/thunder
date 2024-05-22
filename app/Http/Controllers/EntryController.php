<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Conference;
use App\Models\Setting;

class EntryController extends Controller
{
    
    public function create()
    {

        $teams = Team::where('status', 'active')->get();
        $description = Setting::where('name', 'contest_description')->first();
        $description = $description ? $description->value : '';

        $activeConferences = Conference::where('status', 'active')->with(
            [
                'teams' => function($query){
                    $query->where('status', 'active');
                }
            ]
        )->get();

        return view('entry.create',
            [
                'teams'             => $teams,
                'activeConferences' => $activeConferences,
                'description'       => $description
            ]);
    }

}
