<?php

class Route
{
    public static $validRoutes = array();

    public static function set($route, $function)
    {
        self::$validRoutes[] = $route;
        if ($_GET['url'] == $route) {
            $function->__invoke();
        }
    }

    public static function get($route, $function)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return;
        }

        $url = self::checkUrlStructure($route, $_SERVER['REQUEST_URI']);
        if ($url) {
            $params = self::getParams($route, $_SERVER['REQUEST_URI']);
            $function->__invoke($params);
            die();
        }
    }

    public static function getParams($route, $server)
    {
        list($r, $s) = self::urlToArray($route, $server);

        $params = array('params' => array(), 'query' => array());

        foreach ($r as $key => $value) {
            if ($value[0] == ':') {
                $param = explode('?', $s[$key])[0];
                $params['params'][substr($value, 1)] = $param;
            }
        }

        $queryString = explode('?', end($s))[1];
        parse_str($queryString, $params['query']);

        return $params;
    }

    public static function checkUrlStructure($route, $server)
    {
        var_dump(list($r, $s) = self::urlToArray($route, $server));

        if (sizeof($r) != sizeof($s)) {
            echo 'hello';
            return false;
        }

        foreach ($r as $key => $value) {
            if ($value[0] != ':' && $value != $s[$key] || $value[0] == ':' && $s[$key][0] == '?') {
                return false;
            }
        }

        return true;
    }

    public static function urlToArray($route, $server)
    {
        $r = array_values(array_filter(explode('/', $route), function ($val) {
            return $val != '';
        }));
        $s = array_values(array_filter(explode('/', $server), function ($val) {
            return $val != '';
        }));

        var_dump($r);
        var_dump($s);
        return array($r, $s);
    }
}