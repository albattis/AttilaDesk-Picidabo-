<?php


namespace helper;


use app\model\User;

class Redirect
{
    public static function http404($location = "index.php?controller=error&action=404")
    {
        header("HTTP/1.0 404 Not Found");
        header("Location: $location");
        exit();
    }

    public static function go($location = "index.php")
    {
        header("Location: $location");
        exit();
    }

    public static function withMessage($logikai, $category, $message, $location = "index.php")
    {
        if($logikai)
        {
            Alert::addMessage($category,$message);
            Redirect::go('location: index.php?controller=user&action=login');
        }
    }
}