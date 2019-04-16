<?php

class OldToken
{
    public static function generate()
    {
        return OldSession::put(OldConfig::get('session/token_name'), md5(uniqid()));
    }

    // TODO More descriptive name
    public static function check($token)
    {
        $tokenName = OldConfig::get('session/token_name');

        // Does the token stored in the session match the one in the form
        // TODO Make this a function with a descriptive name so comment isn't needed
        if (OldSession::exists($tokenName) && $token == OldSession::get($tokenName)) {
            OldSession::delete($tokenName);
            return true;
        }
        return false;
    }
}