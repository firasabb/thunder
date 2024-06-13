<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Conference;
use App\Models\Setting;
use App\Rules\Recaptcha;
use App\Services\TwilioHandler as Twilio;
use Owenoj\LaravelGetId3\GetId3;
use App\Models\Entry;
use App\Models\VerificationCode;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class EntryController extends Controller
{
    
    public function create()
    {

        $teams = Team::where('status', 'active')->with('conferences')->get();
        $description = Setting::where('name', 'contest_description')->first();
        $description = $description ? $description->value : '';

        $activeConferences = Conference::where('status', 'active')->with(
            [
                'teams' => function($query){
                    $query->where('status', 'active');
                }
            ]
        )->get();

        $teamsOtherConferences = Team::where('status', 'active')->whereHas('conferences', function($query){
            // conference not in active conferences
            $query->where('status', 'active');
        })->get();

        $otherTeams = Team::where('status', 'active')->whereDoesntHave('conferences', function($query){
            // conference not in active conferences
            $query->where('status', 'active');
        })->get();

        return view('entry.create',
            [
                'teams'                 => $teams,
                'activeConferences'     => $activeConferences,
                'description'           => $description,
                'teamsOtherConferences' => $teamsOtherConferences,
                'otherTeams'            => $otherTeams
            ]);
    }


    /**
     * 
     * Store the entry
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function store(Request $request){

        $request->validate([
            'g-recaptcha-response'  => ['required', new Recaptcha],
            'email'                 => 'required|email|max:255',
            'name'                  => 'required|string|max:255',
            'phone'                 => 'required|string|max:255',
            'all'                   => 'required',
            'other'                 => 'required',       
        ]);

        $entry = Entry::create([
            'email' => $request->email,
            'name'  => $request->name,
            'phone' => $request->phone
        ]);

        // Process all teams
        $all = $request->all;
        $all = explode(',', $all);
        foreach($all as $allTeam){
            $allTeam = Team::findOrFail($allTeam);
            $entry->teams()->create([
                'team_id' => $allTeam->team,
                'conference' => 'all'
            ]);
        }

        // Process all other teams
        $other = $request->other;
        $other = explode(',', $other);
        foreach($other as $otherTeam){
            $otherTeam = Team::findOrFail($otherTeam);
            $entry->teams()->create([
                'team_id' => $otherTeam->team,
                'conference' => 'other'
            ]);
        }

        if($request->ACC){
            $entry->teams()->create([
                'team_id' => $request->ACC,
                'conference' => 'ACC'
            ]);
        }

        if($request->B12){
            $entry->teams()->create([
                'team_id' => $request->B12,
                'conference' => 'B12'
            ]);
        }

        if($request->B1G){
            $entry->teams()->create([
                'team_id' => $request->B1G,
                'conference' => 'B1G'
            ]);
        }


        if($request->PAC){
            $entry->teams()->create([
                'team_id' => $request->PAC,
                'conference' => 'PAC'
            ]);
        }


        if($request->SEC){
            $entry->teams()->create([
                'team_id' => $request->SEC,
                'conference' => 'SEC'
            ]);
        }


        // Send a verification code using twilio and the entered phone number
        Twilio::sendVerificationCode($request->phone);

        return redirect()->route('entry.verify', ['entry' => $entry->uuid]);
    }


    /**
     * 
     * Show the verify page
     * 
     */
    public function verify($uuid)
    {
        $entry = Entry::where('uuid', $uuid)->first();
        return view('entry.verify', ['entry' => $entry]);
    }


    /**
     * 
     * 
     * Verify the entry
     * @param Request $request
     * 
     */
    public function verifyEntry(Request $request, $uuid){
            
            $entry = Entry::where('uuid', $uuid)->first();
    
            $request->validate([
                'code' => 'required|string|max:255'
            ]);
    
            $verificationCode = VerificationCode::where('phone', $entry->phone)
                ->where('code', $request->code)
                ->first();
    
            if(!$verificationCode){
                return back()->with('error', 'Invalid verification code');
            }
    
            // Generate confirmation string
            $confirmationCode = Str::uuid();
            $entry->confirmation_code = $confirmationCode;
            $entry->verified_at = now();
            $entry->save();
    
            return redirect()->route('entry.success', ['entry' => $entry->uuid])->with('success', 'Entry verified successfully');
    }


    /**
     * 
     * Show the success page
     * @param string $uuid
     * 
     */
    public function success($uuid){
        $entry = Entry::where('uuid', $uuid)->first();
        return view('entry.success', ['entry' => $entry]);
    }


    public function entryToPdf($uuid){
        $entry = Entry::where('uuid', $uuid)->with('teams')->firstOrFail();
        $pdf = PDF::loadView('entry.pdf', ['entry' => $entry]);
        return $pdf->download('entry.pdf');
    }

}
