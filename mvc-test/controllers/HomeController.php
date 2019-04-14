<?php

class HomeController extends Controller
{
    public function Test()
    {
        $user = $this->Model('UserModel');
        $user->name = 'Alex';

        $this->View('index', ['user' => $user]);
    }
}