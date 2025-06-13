<?php


namespace helper;


class Alert
{
    public static function addMessage($category, $message)
    {
        if(!isset($_SESSION['messages']))
        {
            $_SESSION['messages'] = [];
        }
        if(!array_key_exists($category,$_SESSION['messages']))
        {
            $_SESSION['messages'][$category] = [];
        }

        $_SESSION['messages'][$category][] = $message;
    }

    public static function display($category)
    {
        if(isset($_SESSION['messages']) && isset($_SESSION['messages'][$category]))
        {
            $messages = $_SESSION['messages'][$category];
            include("src/app/view/alert/{$category}.php");
            unset($_SESSION['messages'][$category]);
        }
    }
}