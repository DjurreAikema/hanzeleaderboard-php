<?php

class OldConfig
{
    public static function get($path = null)
    {
        if (!$path) {
            return false;
        }

        // TODO Check if value is actually in the config
        $config = $GLOBALS['OldConfig'];
        $path = explode('/', $path);
        foreach ($path as $bit) {
            if (isset($config[$bit])) {
                $config = $config[$bit];
            }
        }

        return $config;
    }
}