<?php

class AuthController extends Controller
{
    public function login()
    {
        $this->View('auth/login');
    }

    public function logout()
    {
        $this->View('auth/logout');
    }

    public function register()
    {
        $this->View('auth/register');
    }
}