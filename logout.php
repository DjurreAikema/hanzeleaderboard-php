<?php
require_once 'core/init.php';

$user = new OldUser();
$user->logout();

OldRedirect::to('index.php');