<?php

require_once 'Model.php';

class UserModel extends Model
{
    protected $dbTable = 'users';

    public $name;
}