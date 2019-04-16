<?php
session_start();

// TODO Move this to a separate config file for increased security
$GLOBALS['OldConfig'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'OldDB' => 'hanzeleaderboard'
    ),
    'remember' => array(
        'cookie_name' => 'OldHash',
        'cookie_expiry' => 604800
    ),
    'OldSession' => array(
        'session_name' => 'OldUser',
        'token_name' => 'csrf_token'
    )
);

spl_autoload_register(function ($class) {
    require_once 'classes/' . $class . '.php';
});

// TODO Do we want to keep functions like this or move it to a class instead?
require_once 'functions/sanitize.php';

// TODO Is this safe?
if (OldCookie::exists(OldConfig::get('remember/cookie_name')) && !OldSession::exists(OldConfig::get('session/session_name'))) {
    $hash = OldCookie::get(OldConfig::get('remember/cookie_name'));
    $hashCheck = OldDB::conn()->get('user_sessions', array('OldHash', '=', $hash));
    if ($hashCheck->count()) {
        $user = new OldUser($hashCheck->first()->user_id);
        $user->login();
    }
}