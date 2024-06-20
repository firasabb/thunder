<?php 

namespace App\Services;

use Twilio;
use App\Models\VerificationCode;

class TwilioHandler{

    public function receiveMessage(Request $request){
        
        $messageBody = $request->input('Body');
        $phoneNumber = $request->input('From');

        return [
            'messageBody' => $messageBody,
            'phoneNumber' => $phoneNumber
        ];
    }


    public static function sendMessage($phone, $message){

        try{
            $response = Twilio::message($phone, $message);
        } catch(\Exception $e){
            return null;
        }
        return $response;
    }


    /**
     * 
     * Send verification code
     * 
     */
    public static function sendVerificationCode($phone){

        $verificationCode = rand(1000, 9999);
        $message = 'Your verification code is: ' . $verificationCode;

        $response = self::sendMessage($phone, $message);
        if(!$response){
            return null;
        }

        $verificationCode = VerificationCode::create([
            'phone' => $phone,
            'code' => $verificationCode
        ]);

        return $response;
    }

}