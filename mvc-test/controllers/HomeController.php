<?php

class HomeController extends Controller
{
    public static function test()
    {
        print_r(Database::query('SELECT * FROM users'));
    }
}