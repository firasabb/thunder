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

        // create an entry
        $entry = new Entry();
        $entry->save();

        return view('entry.create',
            [
                'teams'                 => $teams,
                'activeConferences'     => $activeConferences,
                'description'           => $description,
                'entry'                 => $entry->uuid
            ]);
    }


    /**
     * 
     * Store the entry teams temporarily
     * 
     */
    public function storeTemporarily(Request $request, $entry = ''){

        $request->validate([
            'conference'    => 'nullable|string|max:255|in:ACC,B12,B1G,PAC,SEC,all,other,winner',
            'teams'         => 'required|string'
        ]);

        // Create or find the entry
        $entry = Entry::where('uuid', $entry)->firstOrFail();
        $conference = $request->conference;
        $teams = json_decode($request->teams);

        // check if entry teams exist
        $entryTeams = $entry->teams()->where('conference', $conference);
        if($entryTeams->first()){
            $entryTeams->delete();
        }

        if($conference == 'ACC' || $conference == 'B12' || $conference == 'B1G' || $conference == 'PAC' || $conference == 'SEC'){

            $teams = Team::whereIn('uuid', $teams)->whereHas('conferences', function($query) use ($conference){
                $query->where('abbreviation', $conference);
            })->get();

            $entry->teams()->createMany($teams->map(function($team) use ($conference){
                return [
                    'team_id' => $team->id,
                    'conference' => $conference
                ];
            })->toArray());

        } else if($conference == 'other') {

            $teams = Team::whereIn('uuid', $teams)->get();
            $entry->teams()->createMany($teams->map(function($team){
                return [
                    'team_id' => $team->id,
                    'conference' => 'other'
                ];
            })->toArray());

        } else if($conference == 'all') {

            $teams = Team::whereIn('uuid', $teams)->get();
            $entry->teams()->createMany($teams->map(function($team){
                return [
                    'team_id' => $team->id,
                    'conference' => 'all'
                ];
            })->toArray());

        } else if($conference == 'winner'){

            $teams = Team::whereIn('uuid', $teams)->get();
            $entry->teams()->createMany($teams->map(function($team){
                return [
                    'team_id' => $team->id,
                    'conference' => 'winner'
                ];
            })->toArray());

        }

    }


    /**
     * 
     * Get the temporary entry
     * 
     */
    public function getEntryTeams($entry = ''){
        $entry = Entry::where('uuid', $entry)->with('teams')->firstOrFail();
        $entryTeams = $entry->teams;
        $teams = [];
        foreach($entryTeams as $entryTeam){
            $team = Team::findOrFail($entryTeam->team_id);
            $teams[] = $team;
        }
        // order the teams by name
        usort($teams, function($a, $b){
            return $a->name <=> $b->name;
        });
        return response()->json($teams);
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
            //'g-recaptcha-response'  => ['required', new Recaptcha],
            'email'                 => 'required|email|max:255',
            'name'                  => 'required|string|max:255',
            'phone'                 => 'required|string|max:255',
            'entry'                 => 'required|string'     
        ]);

        $entry = Entry::where('uuid', $request->entry)->firstOrFail();
        $entry->email = $request->email;
        $entry->name = $request->name;
        $entry->phone = $request->phone;
        $entry->save();

        // validate the entry inputs
        $entry->teams()->where('conference', 'winner')->firstOrFail();
        $entry->teams()->where('conference', 'other')->firstOrFail();
        $entry->teams()->where('conference', 'ACC')->firstOrFail();
        $entry->teams()->where('conference', 'B12')->firstOrFail();
        $entry->teams()->where('conference', 'B1G')->firstOrFail();
        $entry->teams()->where('conference', 'SEC')->firstOrFail();
        $entry->teams()->where('conference', 'all')->get();
        if($entry->teams->count() < 8){
            return back()->with('error', 'Please select 8 teams');
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
        return view('entry.pdf', ['entry' => $entry, 'pdf' => $pdf]);
    }

}
