<?php

namespace Quetab\QuetabPanel\Service;

class Recaptcha{


    /**
     * 
     * @var String
     * 
     */
    private $ip;

    /**
     * 
     * @var String
     * 
     */
    private $recaptcha;


    /**
     * 
     * Constructor
     * 
     */
    public function __construct(?String $recaptcha){
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->recaptcha = $recaptcha;
    }

    /**
     * 
     * Google Recaptcha Validation
     * @param String ip
     * @param String recaptcha string
     * @return Boolean
     * 
     */
    public function validate(){

        $recaptcha = $this->recaptcha;
        $ip = $this->ip;

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
                'secret' => config('services.recaptcha.secret'),
                'response' => $recaptcha,
                'remoteip' => $ip
            ];
        $options = [
            'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);
        if (!$resultJson->success) {
            return false;
        }
        return true;

    }

}