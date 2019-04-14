<?php
require_once('routes.php');

function __autoload($fileName)
{
    if (file_exists('./classes/' . $fileName . '.php')) {
        require_once './classes/' . $fileName . '.php';
    } elseif (file_exists('./controllers/' . $fileName . '.php')) {
        require_once './controllers/' . $fileName . '.php';
    }
}