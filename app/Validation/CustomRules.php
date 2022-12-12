<?php

namespace App\Validation;

use GuzzleHttp\Client;

class CustomRules
{

    // Rule is to validate password upper case characters
    public function includeUpperCase(string $str, string $fields, array $data)
    {


        if (preg_match('/[A-Z]/', $data['password'])) {
            return true;
        } else {

            return false;
        }
    }
    // Rule is to validate password lower case characters
    public function includeLowerCase(string $str, string $fields, array $data)
    {


        if (preg_match('/[a-z]/', $data['password'])) {
            return true;
        } else {

            return false;
        }
    }
    // Rule is to validate password lower case characters
    public function includeNumber(string $str, string $fields, array $data)
    {


        if (preg_match('/[0-9]/', $data['password'])) {
            return true;
        } else {

            return false;
        }
    }
    // Rule is to validate password lower case characters
    public function includeSpecialChars(string $str, string $fields, array $data)
    {


        if (preg_match('/[!?@#$%^&*()\-_=+{};:,<.>]/', $data['password'])) {
            return true;
        } else {

            return false;
        }
    }
    public function isValidNida(string $str, string $fields, array $data)
    {
        $client = new Client();
        $url = 'https://ors.brela.go.tz/um/load/load_nida/' . $data['nationalId'];
        $res = $client->request('POST', $url);
        $data  = json_decode($res->getBody(), true)['obj'];



        if (!key_exists('result', $data)) {
            return false;
        } else {
            return true;
        }
    }

    public function isValidEmail(string $str, string $fields, array $data)
    {
        $email = $data['email'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
}
