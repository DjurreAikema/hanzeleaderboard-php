<?php

class Token
{
    public static function generate()
    {
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    // TODO More descriptive name
    public static function check($token)
    {
        $tokenName = Config::get('session/token_name');

        // Does the token stored in the session match the one in the form
        // TODO Make this a function with a descriptive name so comment isn't needed
        if (Session::exists($tokenName) && $token == Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}