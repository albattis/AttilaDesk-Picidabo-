<?php

use app\model\ReaminingTime;
use app\model\task;
use app\model\Ugyfel;
use app\model\User;

/**
 * @var task $task
 */

$isAdmin = true;
$ugyfel= Ugyfel::findOneById($task->getUgyfelId());
$user= User::findOneById($task->getUserId());
$taskmodify=new task();

if(!empty($_POST))

{
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['close']))
    {
        $taskId = $_GET['id'];
        Task::Taskend($taskId);
        echo json_encode(['status' => 'success']);
        exit();
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reopen']))
        { $taskId = $_GET['id'];
            {
                error_log("Reopen request received for task ID: " . $_GET['id']);
                Task::ReopenTask($taskId);
                echo json_encode(['status' => 'success']);
                exit();
            }
        }
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status']))
        {

            $newStatus = $_POST['status'];
            $taskId = $_GET['id'];
            Task::updateStatus($taskId, $newStatus);
            echo json_encode(['status' => 'success']);
            exit();
        }

}


function refreshpage()
{
    header("Location:$_SERVER[REQUEST_URI]");
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-sm-12">
            <a href="http://localhost/picidabo/index.php?controller=task&action=index" class="btn-gradient-glow btn">Vissza</a>
        </div>
        <div class="col-md-2 col-sm-12">
            <a href="http://localhost/picidabo/index.php?controller=task&action=index" class="btn-fancy-glow btn">Feladat bezárása</a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-6">

            <div class="progress-bar-container">
                <div class="progress-bar" id="progress-bar">
                    <div class="progress-bar-fill" id="progress-bar-fill">

                    </div>
                </div>
                <div class="progress-bar-text" id="progress-bar-text"><?=htmlspecialchars($task->getProgressPercentage())?>%</div>
            </div>


        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
                <label for="taskStatus">Státusz módosítása:</label>
                <select id="taskStatus" style="width:150px;height:50px;" class="form-control">
                    <option value="felvett">Felvett</option>
                    <option value="nyomtatva">Nyomtatva</option>
                    <option value="ertesitve">Értesítve</option>
                    <option value="befejezett">Befejezett</option>
                </select>
            </div>
            <button id="updateStatus" class="btn-primary">Státusz frissítése</button>
        </div>

        <div class="col-md-4 col-md-1">
            <h1>Fentmaradó idő</h1>
            <div id="remainingTime" class="ok-t ime">
                <?php

                if($task->getTaskEndDate()=="0000-00-00 00:00:00")
                {

                    ReaminingTime::countDown($task->getCategoryId(),$task->getTaskDueDate());
                    ?>
                    <script></script><?php
                }
                else
                {
                    echo("A feladat le lett zárva.");
                    ?>
                    <?php
                }
                ?>
            </div>
        </div>

</div>
</div>
     <br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-1">
            <h2>Feladat</h2><br>
            <p>Megnevezés: <?=htmlspecialchars($task->getTaskName())?><br></p>
            <p>Leirás: <?=htmlspecialchars($task->getTaskDescription())?><br></p>
            <p>Felvétel dátuma: <?=htmlspecialchars($task->getTaskDueDate())?></p>
            <p>Felvette:<?=htmlspecialchars($user->getFirstname()." " .$user->getLastname())?></p>

        </div>
        <div class="col-lg-4 col-md-1">
<h2>Ügyfél adatok</h2><br>
    <?php if(!is_null($ugyfel))
    {?>
    <h3><?=htmlspecialchars($ugyfel->getFirstname()." ".$ugyfel->getLastname()) ?> <br></h3>
    <p><?php if(!empty($ugyfel->getZip())&&!empty($ugyfel->getCountry())&&!empty($ugyfel->getStreet())){echo htmlspecialchars($ugyfel->getZip()." " . $ugyfel->getCountry()." ".$ugyfel->getStreet());}else{echo htmlspecialchars("Nincs megadva");} ?> </p>
        <p>E-Mail cim: <?php if(!empty($ugyfel->getEmail())){ echo htmlspecialchars($ugyfel->getEmail());}else{echo("Nincs megadva");}?></p>
        <p>Telefonszám: <?php if(!empty($ugyfel->getPhonenumber())){echo htmlspecialchars($ugyfel->getPhonenumber());}else{echo("Nincs megadva");}?></p>
    <?php } ?>
</div>

    </div>
</div>

    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-lg-3 col-md-1">
                <?php

                if(!$ugyfel->getEmail()=="")
                {
                ?>
                    <form method="post" action="./src/app/view/task/send_email.php">
                        <p>Nem lett E-Mailbe értesitve.</p>
                        <button type="submit" name="sendEmail">E-mail küldése</button>
                    </form>


                <?php } ?>
            </div>
            <div class="col-lg-3 col-md-1">


                <p id="taskvalue">
                    <?php if ($task->getTaskEndDate() == "0000-00-00 00:00:00")
                    { ?> A feladat aktiv.
                    <?php
                    } else
                    { ?> A feladat le van zárva.
                    <?php } ?> </p>
                <button class="btn-success" type="button" id="close"
                    <?php if ($task->getTaskEndDate() != "0000-00-00 00:00:00"&& $task->getTaskStatus()=="befejezett")
                    { echo 'hidden'; } ?>>Feladat lezárása </button>
                <button class="btn-danger" type="button" id="reopen" <?php
                if ($task->getTaskEndDate() == "0000-00-00 00:00:00")
                { echo 'hidden'; } ?>>Feladat visszanyitása </button>

            </div>
            <div class="col-lg-3 col-md-1">
                <form action="index.php?controller=Task&action=view&id=<?=$task->getTaskId()?>" method="post">
                    <p>Határidó modósitása</p>
                    <button class="btn-success"type="submit" id="alapanyag" name="alapanyag">Alapanyag késés.</button>
                </form>
            </div>
        </div>
    </div>



<script>
    var taskId=<?=$task->getTaskId()?>;
     let taskProgress = <?= $task->getProgressPercentage() ?>;
</script>
<script src="./js/kuldes.js"></script>