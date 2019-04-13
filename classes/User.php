<?php

class User
{
    // TODO Have a look at how laravel does this shit for inspiration
    private $_db, $_data, $_sessionName, $_cookieName, $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = DB::conn();

        // TODO Whats the point of this session name?
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        // TODO This code is ugly af
        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    //logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields)
    {
        if (!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account');
        }
    }

    public function update($fields = array(), $id = null)
    {
        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }

        if (!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

    // TODO make this more flexible
    public function find($user = null)
    {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
    }

    // TODO This login is not pretty
    public function login($username = null, $password = null, $remember = false)
    {
        //Check if someone is trying to log in with remember me functionality
        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);

            if ($user) {
                if ($this->data()->password == Hash::makeHash($password, $this->data()->salt)) {
                    Session::put($this->_sessionName, $this->data()->id);

                    // TODO Make this its own method
                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('user_sessions', array('user_id', '=', $this->data()->id));
                        if (!$hashCheck->count()) {
                            $this->_db->insert('user_sessions', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function hasPermission($key)
    {
        $role = $this->_db->get('roles', array('id', '=', $this->data()->role));

        if ($role->count()) {
            $permissions = json_decode($role->first()->permissions, true);

            if ($permissions[$key] == true) {
                return true;
            }
        }
        return false;
    }

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout()
    {
        $this->_db->delete('user_sessions', array('user_id', '=', $this->data()->id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    // TODO Make this like laravel somehow
    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
}