<?php

use app\model\task;
use app\model\Ugyfel;
use app\model\User;

/** @var Ugyfel[] $ugyfelek */

$users = User::getUsers();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskName = $_POST['taskName'];
    $taskDescription = $_POST['taskDescription'];
    $taskCategory = intval($_POST['taskCategory']);
    $dueDate = $_POST['dueDate'];
    $priority = $_POST['taskpriority'];
    $dueDateTime = DateTime::createFromFormat('Y-m-d', $dueDate);
    $dueDateTimeFormatted = $dueDateTime->format('Y-m-d H:i:s');

    $assignedTo = $_POST['assignedTo'];
    $ugyfelid = intval($_POST['ugyfelid']);

    $task = new Task();
    $task->setTaskName($taskName);
    $task->setTaskDescription($taskDescription);
    $task->setCategoryId($taskCategory);
    $task->setTaskPriority($priority);
    $task->setTaskDueDate($dueDateTimeFormatted);
    $task->setUserId($assignedTo);
    $task->setUgyfelId($ugyfelid);

    $endtime = DateTime::createFromFormat('Y-m-d', "0000-00-00");
    $task->setTaskEndDate($endtime->format('Y-m-d H:i:s'));

    if ($task->save()) {
        echo "<p class='success'>A feladat sikeresen felvéve!</p>";
        header("Location: index.php?controller=Task&action=index");
        exit();
    } else {
        echo "<p class='error'>Hiba történt a feladat felvétele során.</p>";
    }
}
?>

<link rel="stylesheet" href="path/to/your/css/file.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#taskCategory').change(function() {
            $('.category-form').hide(); // Elrejtjük az összes kategória formot
            let selectedCategory = $(this).val();
            $('#' + selectedCategory + '-form').show(); // Megjelenítjük a kiválasztott kategóriához tartozó formot
        });
    });
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <a href="http://localhost/picidabo/index.php?controller=task&action=index" class="btn btn-info">Vissza</a>
        </div>
    </div>
</div>
<div class="container-fluid mt-3" style="width:800px;">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Új Feladat Felvétele</h1>
            <br><br>
        </div>
    </div>

    <form id="newTaskForm" method="post" action="index.php?controller=Task&action=insert">
        <div class="mb-3">
            <label for="taskCategory" class="form-label">Kategória:</label>
            <select class="form-select" id="taskCategory" name="taskCategory" required>
                <option value="">Válasszon kategóriát</option>
                <option value="category1">Képnyomtatás</option>
                <option value="category2">Szerviz</option>
                <option value="category3">Névjegykártya készítés</option>
                <option value="category4">Nyomtatás</option>
                <option value="category5">Bevételezés</option>
            </select>
        </div>
        <!-- Kategória 1 form -->
        <div id="category1-form" class="category-form" style="display:none;">
            <div class="mb-3">
                <label for="taskName" class="form-label">Feladat neve:</label>
                <input type="text" class="form-control" id="taskName" name="taskName">
            </div>
            <div class="mb-3">
                <label for="taskDescription" class="form-label">Leírás:</label>
                <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3"></textarea>
            </div>
            <!-- További form elemek ide -->
        </div>
        <!-- Kategória 2 form -->
        <div id="category2-form" class="category-form" style="display:none;">
            <!-- Ide kerülnek a kategória 2 specifikus form elemek -->
        </div>
        <!-- Kategória 3 form -->
        <div id="category3-form" class="category-form" style="display:none;">
            <!-- Ide kerülnek a kategória 3 specifikus form elemek -->
        </div>
        <!-- További kategóriák form elemei -->

        <button type="submit" class="btn btn-primary">Feladat Felvétele</button>
    </form>
</div>

<script>
    $(document).ready(function(){
        var clients = <?= json_encode($ugyfelek) ?>;
        $('#ugyfelid').on('input', function() {
            var query = $(this).val().toLowerCase();
            $('#clientList').empty();
            if (query.length > 0) {
                clients.forEach(function(client) {
                    if (client.firstname.toLowerCase().includes(query) || client.lastname.toLowerCase().includes(query)) {
                        $('#clientList').append(
                            '<li class="list-group-item client-item" data-id="' + client.id + '">' +
                            client.firstname + ' ' + client.lastname + ' - ' + client.street + ', ' + client.zip + ' ' + client.country +
                            '</li>'
                        );
                    }
                });

                $('.client-item').on('click', function() {
                    var clientId = $(this).data('id');
                    $('#ugyfelid').val(clientId);
                    $('#clientList').empty();
                });
            }
        });
    });

    $('#autoFillButton').on('click', function() {
        $('#taskName').val('Compmarket bevételezése');
        $('#taskDescription').val('Bevételezni a Compmarketböl érkezö árut');
        $('#taskCategory').val('5');
        $('#dueDate').val(new Date().toISOString().split('T')[0]);
        $('#taskpriority').val('átlagos');


        $('#ugyfelname').val('Pici Shop - Kossuth L.u. 33, 2117 Isaszeg');
        var client = clients.find(c => c.firstname === 'Pici' && c.lastname === 'Shop');
        if (client) {
            $('#ugyfelid').val(client.id);
        } else {
            console.error('Ügyfél nem található: Pici Shop');
        }
    });


</script>