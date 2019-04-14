<?php

class Controller
{
    public static function View($viewName)
    {
        require_once("./views/$viewName.php");
    }
}