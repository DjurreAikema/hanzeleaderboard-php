<?php

class Hash
{
    // TODO For config
    public function __construct()
    {

    }

    public function passwordHash($password)
    {
        // TODO Move this to a separate config file for security
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    public function passwordCheck($password, $hash)
    {
        return password_verify($password, $hash);
    }
}