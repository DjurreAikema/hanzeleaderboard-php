<?php

class HomeController extends Controller
{
    public function Test()
    {
        $user = $this->Model('UserModel');
        $user->name = 'Alex';

        print_r(Database::query('SELECT * FROM users'));

        $this->View('index', ['user' => $user]);
    }
}