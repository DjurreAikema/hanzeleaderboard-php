<?php

class Input
{
    // Checks if any data exists
    public static function exists($type = 'POST')
    {
        switch ($type) {
            case 'POST':
                return (!empty($_POST)) ? true : false;
                break;
            case 'GET':
                return (!empty($_GET)) ? true : false;
                break;
            default:
                return false;
                break;
        }
    }

    // Returns requested post item
    public static function get($item)
    {
        if (isset($_POST[$item])) {
            return $_POST[$item];
        } elseif (isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }
}