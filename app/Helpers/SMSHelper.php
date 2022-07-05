<?php

namespace App\Helpers;

class SMSHelper
{
    public function sendMessage($message, $destinations)
    {

        $username = env('JAWAL_USERNAME');
        $password = env('JAWAL_PASSWORD');
        $sender = env('JAWAL_SENDERNAME');

        $arrData = [
            "user" => $username,
            "pass" => $password,
            "to" => $destinations,
            "message" => $message,
            "sender" => $sender,
        ];
        
        $getdata = http_build_query($arrData);
        $opts = array('http' => array(
            'method' => 'GET',
            'header' => 'Content-type: application/x-www-form-urlencoded',
        ),
        );

        $context = stream_context_create($opts);
        $results = file_get_contents('https://www.jawalbsms.ws/api.php/sendsms?' . $getdata, false, $context);
        return $results;
    }
}
