<?php

// TODO The hashing needs to be updated it feels very old
class OldHash
{
    public static function makeHash($string, $salt = '')
    {
        return hash('sha256', $string . $salt);
    }

    public static function makeSalt($length)
    {
        return random_bytes($length);
    }

    public static function unique()
    {
        return self::makeHash(uniqid());
    }
}