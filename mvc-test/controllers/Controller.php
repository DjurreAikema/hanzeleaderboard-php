<?php

class Controller
{
    public static function View($view, $data = [])
    {
        if ($data) {
            extract($data);
        }
        unset($data);

        require_once("./views/$view.php");
    }

    public function Model($model)
    {
        require_once("./models/$model.php");
        return new $model();
    }
}