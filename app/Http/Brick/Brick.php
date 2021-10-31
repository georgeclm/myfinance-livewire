<?php

namespace App\Http\Brick;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;

class Brick
{


    public function getAccessToken()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://sandbox.onebrick.io/v1/auth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERPWD, '9bb5fc0d-0b48-4991-8f7e-a4e4b94171e8' . ':' . 'tZYWvzNEGLE5gyDWYJ3uCs8A0IJkAf');

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return json_decode($result);
    }
    public function InstitutionList()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://sandbox.onebrick.io/v1/institution/list');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $accessToken = $this->getAccessToken()->data->access_token;
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $accessToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result);
    }
}
