<?php

/**
 * @var Ugyfel[] $ugyfelek
 */


use app\model\task;
use app\model\Ugyfel;
use app\model\User;

$users = User::getUsers();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        $taskName = $_POST['taskName'];
        $taskDescription = $_POST['taskDescription'];
        $taskCategory = intval($_POST['taskCategory']);
        $dueDate = $_POST['dueDate'];
        $priority=$_POST['taskpriority'];
        $dueDateTime = DateTime::createFromFormat('Y-m-d', $dueDate);
        $dueDateTimeFormatted = $dueDateTime->format('Y-m-d H:i:s');

        $assignedTo = $_POST['assignedTo'];
        $ugyfelid=intval($_POST['ugyfelid']);
        $task = new Task();
        $task->setTaskName($taskName);
        $task->settaskDescription($taskDescription);
        $task->setcategoryId($taskCategory);
        $task->setTaskPriority($priority);
        $task->setTaskDueDate($dueDateTimeFormatted);
        $task->setUserId($assignedTo);
        $task->setUgyfelId($ugyfelid);
        $endtime=DateTime::createFromFormat('Y-m-d',"0000-00-00");
        $task->setTaskEndDate($endtime->format('Y-m-d H:i:s'));
        if ($task->save())
        { echo "<p class='success'>A feladat sikeresen felvéve!</p>";
            header("Location: index.php?controller=Task&action=index");
        }
        else
        { echo "<p class='error'>Hiba történt a feladat felvétele során.</p>";
        }

    }?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./js/klient.js"></script>

<style>

    .container-fluid-form {
        max-width: 800px;
        margin: auto;
    }

    .form-label {
        font-weight: bold;
        color: #0d47a1; /* Sötétkék szöveg */
    }

    .form-control, .form-select {
        border: 2px solid #0d47a1; /* Sötétkék keret */
        border-radius: 8px;
        padding: 10px;
        background-color: #f0f0f0; /* Halvány szürke háttér */
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    }

    .form-control:focus, .form-select:focus, .form-control:active, .form-select:active {
        background-color: #dcdcdc;
        border-color: #2196f3;
        box-shadow: 0 0 10px rgba(33, 150, 243, 0.5);
    }

    .btn-primary, .btn-info, .btn-secondary {
        background: linear-gradient(45deg, #1e88e5, #42a5f5); /* Világosabb kék */
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        color: #ffffff;
        font-weight: bold;
        transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover, .btn-info:hover, .btn-secondary:hover {
        background: linear-gradient(45deg, #42a5f5, #1e88e5);
        box-shadow: 0 4px 8px rgba(33, 150, 243, 0.5), 0 0 10px rgba(33, 150, 243, 0.7);
        transform: scale(1.05); /* Finom nagyítás hover hatásra */
    }

    .btn-glow {
        background: linear-gradient(45deg, #1e88e5, #42a5f5); /* Világosabb kék */
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        color: #ffffff;
        font-weight: bold;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3), 0 0 15px rgba(0, 123, 255, 0.5);
        transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-glow:hover {
        background: linear-gradient(45deg, #42a5f5, #1e88e5);
        box-shadow: 0 4px 8px rgba(33, 150, 243, 0.5), 0 0 20px rgba(33, 150, 243, 0.7);
        transform: scale(1.05);
    }

    .form-container {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb, #90caf9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1.text-center {
        color: #0d47a1;
        font-weight: bold;
    }

    .ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 8px;
        border-radius: 50%;
        border: 6px solid #3498db;
        border-color: #3498db transparent #3498db transparent;
        animation: ring-spin 1.2s linear infinite;
    }
    @keyframes ring-spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    #loadingSpinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1050; /* A modális ablak fölé helyezés */
        text-align: center;
    }



</style>

<!-- Spinner hozzáadása -->
<div id="loadingSpinner" style="display: none;">
    <div class="ring"></div>
</div>

<div class="container-fluid-form mt-3 form-container">
    <div class="row">
        <div class="col-2">
            <a href="http://localhost/picidabo/index.php?controller=task&action=index" class="btn btn-info">Vissza</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Új Feladat Felvétele</h1>
            <br><br>
        </div>
    </div>

    <form id="newTaskForm" method="post" action="index.php?controller=Task&action=insert">
        <div class="row">
            <div class="col-2 m-2">
                <button type="button" class="btn btn-secondary" id="autoFillButton">Compmarket bevételezése</button>
            </div>
            <div class="col-2 m-2">
                <button type="button" class="btn btn-secondary" id="compmarketButton">Compmarket leadása</button>
            </div>
            <div class="col-2 m-2">
                <button type="button" class="btn btn-secondary" id="copydepoButton">Copydepo leadása</button>
            </div>
            <div class="col-2 m-2">
                <button type="button" class="btn btn-secondary" id="copydepobevetelezesButton">Copydepo Bevételezése</button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="taskName" class="form-label">Feladat neve:</label>
                    <input type="text" class="form-control" id="taskName" name="taskName" required>
                </div>
                <div class="mb-3">
                    <label for="taskDescription" class="form-label">Leírás:</label>
                    <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3" required></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="taskCategory" class="form-label">Kategória:</label>
                    <select class="form-select" id="taskCategory" name="taskCategory" required>
                        <option value="?">Válassz...</option>
                        <option value="1">Képnyomtatás</option>
                        <option value="2">Szerviz</option>
                        <option value="3">Névjegykártya készítés</option>
                        <option value="4">Nyomtatás</option>
                        <option value="5">Bevételezés</option>
                        <option value="6">Rendelés</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dueDate" class="form-label">Felvétel dátuma:</label>
                    <input type="date" class="form-control" id="dueDate" name="dueDate" required>
                </div>
                <div class="mb-3">
                    <label for="taskpriority" class="form-label">Prioritás:</label>
                    <select class="form-select" id="taskpriority" name="taskpriority" required>
                        <option value="átlagos" selected>Átlagos</option>
                        <option value="magas">Magas</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="assignedTo" class="form-label">Felelős:</label>
                    <select class="form-select" id="assignedTo" name="assignedTo" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"<?php if($user["id"]==$_SESSION['user_id']){?> selected<?php }?>><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname'])?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ugyfelid" class="form-label">Ügyfél:</label>
                    <input type="text" class="form-control" id="ugyfelid" name="ugyfelid" required>
                    <ul class="list-group" id="clientList"></ul>
                </div>
                <button type="submit" class="btn btn-primary btn-glow">Feladat Felvétele</button>
            </div>
        </div>

        <div id="kepnyomtatasSection" style="display: none;">
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="paperType" class="form-label">Papír típus:</label>
                        <select class="form-select" id="paperType" name="paperType">
                            <option value="sima">Sima papír</option>
                            <option value="foto">Fotó papír</option>
                            <option value="160gm">160 gm-os papír</option>
                            <option value="300gm">300 gm-os papír</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="formatType" class="form-label">Formátum:</label>
                        <select class="form-select" id="formatType" name="formatType">
                            <option value="email">E-mail</option>
                            <option value="pendrive">Pendrive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="printSize" class="form-label">Nyomtatási méret:</label>
                        <select class="form-select" id="printSize" name="printSize">
                            <option value="A3">A/3</option>
                            <option value="A4">A/4</option>
                            <option value="A5">A/5</option>
                            <option value="A6">A/6</option>
                            <option value="10x15">10x15</option>
                            <option value="other">Egyéb</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div id="rendelesSection" style="display: none;">
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="mb-3"> <label for="orderCategory" class="form-label">Rendelés Kategória:</label>
                        <select class="form-select" id="orderCategory" name="orderCategory">
                            <option value="Nyomtató">Nyomtató</option>
                            <option value="Gép ősszeállitas">Gép összeállítás</option>
                            <option value="papir irószer">Papír-írószer</option>
                            <option value="Fénykép">Fénykép</option>
                            <option value="Kábel">Kábel</option>
                            <option value="Laptop alkatrész">Laptopalkatrész</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Laptop">Laptop</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div id="nevjegykartyaSection" style="display: none;">
            <div class="row mt-3">
                
                    <div class="col-4 mb-3">
                        <label for="sideCount" class="form-label">Oldalak száma:</label>
                        <select class="form-select" id="sideCount" name="sideCount">
                            <option value="1-oldalas">1 oldalas</option>
                            <option value="2-oldalas">2 oldalas</option>
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="colorType" class="form-label">Szín:</label>
                        <select class="form-select" id="colorType" name="colorType">
                            <option value="fekete-fehér">Fekete-fehér</option>
                            <option value="szines">Színes</option>
                        </select>
                    </div>
                    <div class="col-4 mb-3">
                        <label for="formatType" class="form-label">Formátum:</label>
                        <select class="form-select" id="formatType" name="formatType">
                            <option value="E-mail">E-mail</option>
                            <option value="Pendrive">Pendrive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<div class="col-md-4">
    <div id="clientDetails" style="display: none;">
        <h3>Ügyfél Adatok</h3>
        <p><strong>Név:</strong> <span id="clientName"></span></p>
        <p><strong>Cím:</strong> <span id="clientAddress"></span></p>
        <p><strong>Telefon:</strong> <span id="clientPhone"></span></p>
        <p><strong>E-mail:</strong> <span id="clientEmail"></span></p>
    </div>
</div>


<br><br>

<script>

    $(document).ready(function(){
        var clients = <?= json_encode($ugyfelek) ?>;

        // Jelenlegi dátum automatikus beállítása időzóna figyelembevételével
        function getCurrentDate() {
            var today = new Date();
            var yyyy = today.getFullYear();
            var mm = String(today.getMonth() + 1).padStart(2, '0'); // Hónapok 0-tól indulnak
            var dd = String(today.getDate()).padStart(2, '0');
            return yyyy + '-' + mm + '-' + dd;
        }

        $('#dueDate').val(getCurrentDate());

        // Ügyfél keresése
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

                    // Ügyfél adatok megjelenítése spinner animációval
                    $('#loadingSpinner').show();
                    setTimeout(function() {
                        var selectedClient = clients.find(c => c.id == clientId);
                        if (selectedClient) {
                            $('#clientName').text(selectedClient.firstname + ' ' + selectedClient.lastname);
                            $('#clientAddress').text(selectedClient.street + ', ' + selectedClient.zip + ' ' + selectedClient.country);
                            $('#clientPhone').text(selectedClient.phonenumber);
                            $('#clientEmail').text(selectedClient.email);
                            $('#clientDetails').show();
                            $('#loadingSpinner').hide();
                        }
                    }, 1000); // 1 másodperc késleltetés
                });
            }
        });

        // Dinamikus megjelenítés a kiválasztott kategória alapján spinner animációval
        $('#taskCategory').on('change', function() {
            var selectedCategory = $(this).val();
            $('#loadingSpinner').show();
            setTimeout(function() {
                if (selectedCategory == 1) { // Képnyomtatás kategória
                    $('#kepnyomtatasSection').show();
                    $('#rendelesSection').hide();
                    $('#nevjegykartyaSection').hide();
                } else if (selectedCategory == 6) { // Rendelés kategória
                    $('#rendelesSection').show();
                    $('#kepnyomtatasSection').hide();
                    $('#nevjegykartyaSection').hide();
                } else if (selectedCategory == 3) { // Névjegykártya nyomtatás kategória
                    $('#nevjegykartyaSection').show();
                    $('#kepnyomtatasSection').hide();
                    $('#rendelesSection').hide();
                } else {
                    $('#kepnyomtatasSection').hide();
                    $('#rendelesSection').hide();
                    $('#nevjegykartyaSection').hide();
                }
                $('#loadingSpinner').hide();
                updateTaskDescription(); // Frissítse a leírást az új kategória alapján
            }, 1000); // 1 másodperc késleltetés
        });

        // Frissítsük a feladat leírását a kiválasztott opciók alapján
        $('#paperType, #formatType, #printSize, #orderCategory, #sideCount, #colorType').on('change', function() {
            updateTaskDescription();
        });

        function updateTaskDescription() {
            var selectedCategory = $('#taskCategory').val();
            var description = '';

            if (selectedCategory == 1) { // Képnyomtatás kategória
                var paperType = $('#paperType').val();
                var formatType = $('#formatType').val();
                var printSize = $('#printSize').val();
                description = 'Nyomtatás ' + printSize + ' méretben, ' + formatType + '-on, ' + paperType + ' papírra.';
            } else if (selectedCategory == 6) { // Rendelés kategória
                var orderCategory = $('#orderCategory').val();
                description = 'Rendelés kategória: ' + orderCategory;
            } else if (selectedCategory == 3) { // Névjegykártya nyomtatás kategória
                var sideCount = $('#sideCount').val();
                var colorType = $('#colorType').val();
                var formatType = $('#formatType').val();
                description = 'Névjegykártya nyomtatás ' + sideCount + ', ' + colorType + ' színben, ' + formatType + '(ról) küldve.';
            }

            $('#taskDescription').val(description);
        }

        // Automatikus űrlapkitöltés gombok
        $('#autoFillButton').on('click', function() {
            fillForm('Compmarket bevételezése', 'Bevételezni a Compmarketböl érkezö árut', '5', 'átlagos', 'Pici', 'Shop');
        });

        $('#compmarketButton').on('click', function() {
            fillForm('Compmarket leadása', 'Leadni a Compmarketböl érkezö árut', '5', 'átlagos', 'Pici', 'Shop');
        });

        $('#copydepoButton').on('click', function() {
            fillForm('Copydepo lerendelése', 'Kirendelni a copydepoból érkezö árut', '5', 'átlagos', 'Pici', 'Shop');
        });

        $('#copydepobevetelezesButton').on('click', function() {
            fillForm('Copydepo bevételezése', 'Bevételezni a Copydepoból érkezö árut', '5', 'átlagos', 'Pici', 'Shop');
        });

        function fillForm(taskName, taskDescription, taskCategory, taskPriority, clientFirstname, clientLastname) {
            $('#taskName').val(taskName);
            $('#taskDescription').val(taskDescription);
            $('#taskCategory').val(taskCategory);
            $('#dueDate').val(getCurrentDate()); // Automatikus kitöltés jelenlegi dátummal
            $('#taskpriority').val(taskPriority);

            var client = clients.find(c => c.firstname === clientFirstname && c.lastname === clientLastname);
            if (client) {
                $('#ugyfelid').val(client.id);
                $('#clientName').text(client.firstname + ' ' + client.lastname);
                $('#clientAddress').text(client.street + ', ' + client.zip + ' ' + client.country);
                $('#clientPhone').text(client.phonenumber);
                $('#clientEmail').text(client.email);
                $('#clientDetails').show();
            } else {
                console.error('Ügyfél nem található: ' + clientFirstname + ' ' + clientLastname);
            }
        }
    });


</script>