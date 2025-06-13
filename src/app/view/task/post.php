<?php



use app\model\task;


if(isset($_POST["close"]))
{

    task::Taskend($_GET["id"]);
}
