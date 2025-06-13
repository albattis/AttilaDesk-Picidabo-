<?php
use app\model\Task;

/** @var
 * $tasks Task[]
 */

$admin=true;

$showClosedTasks = isset($_GET['showClosedTasks']) && $_GET['showClosedTasks'] === 'true';

?>

<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-2">
            <a href="index.php?controller=user&action=index" class="btn btn-info">Vissza</a>
        </div>
        <div class="col-2">
            <a href="index.php?controller=Task&action=index&showClosedTasks=<?=$showClosedTasks ? 'false' : 'true'?>" class="btn btn-primary"><?= $showClosedTasks ? 'Aktív feladatok' : 'Lezárt feladatok' ?></a>
        </div>
    </div>
    </div>
    <br><br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php if(!empty($_SESSION["user_id"])) { ?>
                <table class="task_table">
                    <tr class="task_tabledata">
                        <td class="task_table_row">Sorszám</td>
                        <td class="task_table_row_description">Leírás</td>
                        <td style="width: 150px;height: 50px;">Felvétel dátuma</td>
                        <td class="task_table_row">Felvette</td>
                        <td class="task_table_row" style="width:70px;">Haladás</td>
                        <td class="task_table_row ml-4"style="width:150px;" >Modósitás</td>
                        <td class="task_table_row">Admin</td>
                    </tr>
                    <?php foreach ($tasks as $task) : ?>
                    <?php if($showClosedTasks && $task->getTaskEndDate() != "0000-00-00 00:00:00" || !$showClosedTasks && $task->getTaskEndDate() == "0000-00-00 00:00:00") { ?>
                    <?php if ($task->getTaskPriority() == "magas")
                    { ?><tr class="task_tabledata_priority"><?php } else { ?><tr class="task_tabledata"><?php } ?>
                        <td><?=$task->getTaskId()?></td>
                        <td><?=$task->getTaskDescription()?></td>
                        <td><?=$task->getTaskDueDate()?></td>
                        <?php $user = \app\model\User::findOneById($task->getUserId()); ?>
                        <td><?=$user->getFirstname() . " " . $user->getLastname()?></td>
                        <td>
                            <div class="progress-bar-container">
                                <div class="progress-bar" id="progress-bar-<?=$task->getTaskId()?>">
                                    <div class="progress-bar-fill" id="progress-bar-fill-<?=$task->getTaskId()?>"></div>
                                </div>
                                <div class="progress-bar-text" id="progress-bar-text-<?=$task->getTaskId()?>">0%</div>
                            </div>
                        </td>
                        <?php if ($task->getTaskStatus() != "befejezett")
                        {
                            ?><td><a class="btn btn-fancy-glow" href="index.php?controller=Task&action=view&id=<?=$task->getTaskId()?>">Módosít</a></td>

                        <?php }else echo("<td></td>") ?>
                        <?php if($admin && $task->getTaskStatus()=="befejezett")
                        {?>
                            <td><a class="btn btn-warning" href="index.php?controller=Task&action=view&id=<?=$task->getTaskId()?>">Módosít</a></td>
                        <?php } else echo("<td></td>") ?>


                        <?php } endforeach; } else { ?><h1>Nincs bejelentkezett felhasználó</h1><a class="btn btn-primary ml-4" href="index.php">Bejelentkezés</a><?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskList = <?php
            echo json_encode(array_map(function($task) {
                return [
                    'id' => $task->getTaskId(),
                    'progress' => $task->getProgressPercentage()
                ];
            }, $tasks));
            ?>;

        taskList.forEach(task => {
            updateProgressBar(task.id, task.progress);
        });

        function updateProgressBar(taskId, progress) {
            const progressBarFill = document.getElementById(`progress-bar-fill-${taskId}`);
            const progressBarText = document.getElementById(`progress-bar-text-${taskId}`);
            if (progressBarFill && progressBarText) {
                progressBarFill.style.width = progress + '%';
                progressBarText.textContent = progress + '%';
                if (progress >= 100) {
                    progressBarFill.style.backgroundColor = '#76c7c0';
                    progressBarText.textContent = 'Kész!';
                }
            }
        }
    });
</script>
