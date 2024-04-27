<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Models\User;
use Models\UserPhone;
use Models\VerificationCode;
use Twilio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PhoneVerificationController extends Controller
{
    /**
     * 
     * Show the verification page
     * @param Request $request
     * 
     */
    public function show(Request $request){
        return view('user.verifyphone');
    }

    /**
     * 
     * Check if the user is verified
     * @param Request $request
     * 
     */
    public function verify(Request $request){
        if ($request->user()->verification_code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => ['The code your provided is wrong. Please try again or request another call.'],
            ]);
        }
        if ($request->user()->phoneVerified()) {
            return redirect()->route('dashboard.redirect');
        }
        $request->user()->markPhoneAsVerified();
        return redirect()->route('dashboard.redirect')->with('status', 'Your phone was successfully verified!');
    }


    /**
     * 
     * Send a verification Code to the user
     * @param Request $request
     * 
     */
    public function send(Request $request){

        $request->validate([
            'country' => 'required|string',
            'phone' => 'required|string'
        ]);

        $user = $request->user();
        $code = $this->generateVerificationCode($user);

        if($code === false){
            return response()->json(['message' => 'exceeded limit']);
        }

        preg_match_all('!\d+!', $request->phone, $phone);
        $phone = implode('', $phone[0]);

        // Change this in future
        $country = $request->country;
        $area = substr($phone, -10, -7);
        $prefix = substr($phone, -7, -4);
        $line = substr($phone, -4, 4);

        $mobilePhone = $country . $phone;
        $message = 'Your verification code is: ' . $code;
        $message = Twilio::message($mobilePhone, $message);

        $userPhone = $user->phones()->create([
            'status'    => 'verification',
            'country'   => $country,
            'area'      => $area,
            'prefix'    => $prefix,
            'line'      => $line
        ]);

        return response()->json(['message' => 'code sent']);
    }


    /**
     * 
     * Match the request code and the stored code
     * @param Request $request
     * 
     */
    public function match(Request $request){

        $request->validate([
            'code'  =>  'required|string'
        ]);

        $user = $request->user();
        $code = $request->code;

        $dateLimit = Carbon::now()->subHour();
        $verificationCode = $user->verificationCodes()->where([['created_at', '>', $dateLimit], ['verified', 0]])->latest()->first()->makeVisible('verification_code');

        if($verificationCode && $hashedVerificationCode = $verificationCode->verification_code){
            if(Hash::check($code, $hashedVerificationCode)){
                $verificationCode->verified = 1;
                $verificationCode->save();
                $user->verifyPhone();
                return response()->json(['message' => 'verified']);
            }
        }
        
        return response()->json(['message' => 'could not verify']);
    }


    /**
     * 
     * Generate phone verification code
     * @return int $code
     * 
     */
    private function generateVerificationCode($user){

        if($this->verificationCodeLimiter($user)){
            $code = random_int(100000, 999999);
            $user->verificationCodes()->create([
                'verification_code' => bcrypt($code)
            ]);
            return $code;
        }
        
        return false;
    }


    /**
     * 
     * Make sure that the user doesn't request to many verificatio codes
     * @return bool
     * 
     */

    private function verificationCodeLimiter($user){

        // No more than 3 requests in the last hour
        $dateLimit = Carbon::now()->subHour();
        $count = $user->verificationCodes()->where('created_at', '>', $dateLimit)->count();

        return $count <= 3;
    }
}
