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


    /**
     * 
     * Show the create video form
     * @return \Illuminate\View\View
     * 
     */
    public function video()
    {
        return view('entry.video');
    }


    /**
     * 
     * Submit video
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     */
    public function submitVideo(Request $request){
            
            $request->validate([
                'g-recaptcha-response'  => ['required', new Recaptcha],
                'video'                 => 'required|file|mimes:mp4,mov,avi,wmv,flv,webm|max:102400',
            ]);
    
            $video = $request->file('video');
            $video->store('videos');
    
            return redirect()->route('entry.create')->with('success', 'Video uploaded successfully');
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
        ]);

        $entry = Entry::create([
            'email' => $request->email,
            'name'  => $request->name,
            'phone' => $request->phone
        ]);

        // Send a verification code using twilio and the entered phone number
        //Twilio::sendVerificationCode($request->phone);

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

}
