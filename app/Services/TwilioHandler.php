<?php 

namespace App\Services;

use Twilio;

class TwilioHandler{

    public function receiveMessage(Request $request){
        
        $messageBody = $request->input('Body');
        $phoneNumber = $request->input('From');

        return [
            'messageBody' => $messageBody,
            'phoneNumber' => $phoneNumber
        ];
    }


    public function sendMessage($phone, $message){

        try{
            $response = Twilio::message($phone, $message);
        } catch(\Exception $e){
            return $e->getMessage();
        }

        return $response;

    }

}