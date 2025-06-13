<?php

use app\controller\SzabadsagController;
use app\model\Album;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL );

require("vendor/autoload.php");
/*
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
*/
session_start();

$controllerName = !empty($_GET['controller'])?ucfirst($_GET['controller']) . "Controller":"UserController";
$actionName = !empty($_GET['action'])?"action".ucfirst($_GET['action']):"actionLogin";

if ($controllerName == "UserController" && $actionName == "actionLogin" && isset($_SESSION['jwt']))
{
    header("Location: index.php?controller=User&action=index");
    exit;
}

$content = "404";



if($controllerName == "UserController") {
    $controller = new \app\controller\UserController();

    if($actionName == "actionLogin")
    {
        $content = $controller->actionLogin();
    }
    else if($actionName == "actionLogout")
    {
        $content = $controller->actionLogout();
    }
    else if($actionName == "actionIndex")
    {
        $content = $controller->actionIndex();
    }
    else if($actionName=="actionAddUser")
        {

            $content=$controller->actionInsert();
        }
}
if($controllerName == "SzabadsagController")
{
    $controller=new SzabadsagController();
        if($actionName == "actionIndex")
        {
            $content = $controller->actionIndex();
        }
}
else if($controllerName=="UgyfelController")
{
    $controller=new \app\controller\UgyfelController();
    if($actionName== "actionInsert")
    {
        $content= $controller->actionInsert();
    }
    else if($actionName == "actionIndex")
    {
        $content = $controller->actionIndex();
    }
}
if($controllerName == "TaskController")
{
    $controller = new \app\controller\TaskController();

    if($actionName == "actionIndex")
    {
        $content = $controller->actionIndex();
    }else if($actionName=="actionView")
    {
        $content=$controller->actionView($_GET["id"]);
    }else if($actionName="actionInsert")
    {
        $content=$controller->actionInsert();
    }

}


include("src/app/view/template/main-template.php");