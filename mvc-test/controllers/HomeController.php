<?php

class HomeController extends Controller
{
    public function Test()
    {
        $user = $this->Model('UserModel');

        $this->View('index', ['users' => $user->all()]);
    }
}