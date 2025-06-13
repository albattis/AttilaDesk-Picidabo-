<?php
/** @var ugyfel[] $ugyfel
 */

use app\model\Ugyfel;


// Frissítjük az ügyfél adatait a POST adatok alapján



?>
<style>
    .list-group-item {
        padding: 15px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #e9e9e9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .list-group-item.client-name-item {
        cursor: pointer;
        background: linear-gradient(45deg, #42a5f5, #478ed1, #5a5bd6);
        color: #ffffff;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .list-group-item.client-name-item:hover {
        background: linear-gradient(45deg, #5a5bd6, #478ed1, #42a5f5);
        box-shadow: 0 4px 8px rgba(66, 165, 245, 0.5);
        transform: translateY(-2px);
    }

    .list-group-item.client-item:hover {
        background: linear-gradient(45deg, #42a5f5, #478ed1, #5a5bd6);
        color: #ffffff;
        box-shadow: 0 4px 8px rgba(66, 165, 245, 0.5);
        transform: translateY(-2px);
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        animation: fadein 1s ease-in-out;
    }

    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }

    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }

    @keyframes fadein {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    #clientNamesList
    {
        max-height: 300px; /* Állítsd be a kívánt magasságot */
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
        background-color: #42a5f5;
    }

     .ring {
         display: inline-block;
         width: 80px;
         height: 80px;
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



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="editClientModal" tabindex="-1" role="dialog" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClientModalLabel">Ügyfél adatok módosítása</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editClientForm" action="src/app/view/ugyfel/updateClient.php" method="post">
                    <input type="hidden" id="editClientId" name="clientId">
                    <div class="form-group">
                        <label for="editClientName">Név:</label>
                        <input type="text" class="form-control" id="editClientName" name="clientName" required>
                    </div>
                    <div class="form-group">
                        <label for="editClientZip">Irányítószám:</label>
                        <input type="text" class="form-control" id="editClientZip" name="clientZip" required>
                    </div>
                    <div class="form-group">
                        <label for="editClientCity">Város:</label>
                        <input type="text" class="form-control" id="editClientCity" name="clientCity" required>
                    </div>
                    <div class="form-group">
                        <label for="editClientStreet">Utca:</label>
                        <input type="text" class="form-control" id="editClientStreet" name="clientStreet" required>
                    </div>
                    <div class="form-group">
                        <label for="editClientPhone">Telefonszám:</label>
                        <input type="text" class="form-control" id="editClientPhone" name="clientPhone" required>
                    </div>
                    <div class="form-group">
                        <label for="editClientEmail">E-Mail:</label>
                        <input type="email" class="form-control" id="editClientEmail" name="clientEmail" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Mentés</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div id="feedback-message" class="alert" style="display: none;"></div>
    <div class="row">
        <div class="col-12">
            <h1 style="text-align: center;">Aktuális ügyfeleink száma: <?= \app\model\Ugyfel::allUgyfelCount(); ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-12 mb-3">
            <label for="ugyfelid" class="form-label">Ügyfél:</label>
            <input type="text" class="form-control" id="ugyfelid" name="ugyfelid" required>
        </div>
        <div class="col-md-3 col-sm-12 mb-3">
            <label for="ugyfelnevek" class="form-label">Ügyfelek Nevei:</label>
            <ul class="list-group" id="clientNamesList" style="max-height: 300px; overflow-y: auto;">
                <?php foreach ($ugyfel as $client) : ?>
                    <li class="list-group-item client-name-item" data-id="<?= $client['id']; ?>">
                        <?= htmlspecialchars($client['firstname'] . ' ' . $client['lastname']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-4 col-sm-12">
            <label for="nev">Név:</label><p id="ugyfelnev"></p>
            <label for="iranyitoszam">Irányítószám:</label><p id="ugyfeliranyitoszam"></p>
            <label for="varos">Város:</label><p id="ugyfelvaros"></p>
            <label for="utca">Utca:</label><p id="ugyfelutca"></p>
            <label for="ugyfeltelefonszam">Telefonszám:</label><p id="ugyfeltelefonszam"></p>
            <label for="ugydfelemail">E-Mail:</label><p id="ugydfelemail"></p>
            <button class="btn btn-primary" id="editClientButton">Adatok módosítása</button>
        </div>
    </div>
    <div id="loadingSpinner" style="display: none;">
        <div class="ring"></div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var clients = <?= json_encode($ugyfel) ?>;
        console.log('Clients:', clients);

        // Keresőmező a lista szűréséhez
        $('#ugyfelid').on('input', function() {
            var query = $(this).val().toLowerCase();
            $('#clientNamesList .client-name-item').each(function() {
                var clientName = $(this).text().toLowerCase();
                if (clientName.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Eseménykezelés a listaelemekre
        $('#clientNamesList').on('click', '.client-name-item', function() {
            var clientId = $(this).data('id');
            console.log(clientId);
            $('#ugyfelid').val(clientId);
            var selectedClient = clients.find(c => c.id == clientId);
            $('#ugyfelnev').text(selectedClient.firstname + ' ' + selectedClient.lastname);
            $('#ugyfeliranyitoszam').text(selectedClient.zip);
            $('#ugyfelvaros').text(selectedClient.country);
            $('#ugyfelutca').text(selectedClient.street);
            $('#ugyfeltelefonszam').text(selectedClient.phonenumber);
            $('#ugydfelemail').text(selectedClient.email);
        });

        $('#editClientForm').on('submit', function(event) {
            event.preventDefault();

            // Spinner megjelenítése
            $('#loadingSpinner').show();

            let formData = new FormData(this);

            // Szimulált késleltetés a fetch kérés előtt
            setTimeout(() => {
                fetch('/picidabo/src/app/view/ugyfel/updateClient.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                    .then(data => {
                        // Spinner elrejtése
                        $('#loadingSpinner').hide();

                        if (data.success) {
                            // Modális ablak bezárása
                            $('#editClientModal').modal('hide');

                            // Üzenet megjelenítése
                            $('#feedback-message').removeClass('alert-danger').addClass('alert-success').text('Az adatok sikeresen frissítve!').show();

                            // Sikeres módosítás után átirányítás
                            setTimeout(() => {
                                window.location.href = '/picidabo/index.php?controller=Ugyfel&action=index';
                            }, 2000); // 2 másodperc után átirányítás
                        } else {
                            $('#feedback-message').removeClass('alert-success').addClass('alert-danger').text('Hiba történt: ' + data.message).show();
                            setTimeout(() => {
                                $('#feedback-message').hide();
                            }, 5000); // Az üzenet 5 másodperc múlva eltűnik
                        }
                    }).catch(error => {
                    console.error('Error:', error);
                    // Spinner elrejtése
                    $('#loadingSpinner').hide();

                    $('#feedback-message').removeClass('alert-success').addClass('alert-danger').text('Hiba történt: ' + error.message).show();
                    setTimeout(() => {
                        $('#feedback-message').hide();
                    }, 5000); // Az üzenet 5 másodperc múlva eltűnik
                });
            }, 3000); // Szimulált késleltetés 2 másodpercig
        });

        $('#editClientButton').on('click', function() {
            var clientId = $('#ugyfelid').val();
            var selectedClient = clients.find(c => c.id == clientId);

            $('#editClientId').val(selectedClient.id);
            $('#editClientName').val(selectedClient.firstname + ' ' + selectedClient.lastname);
            $('#editClientZip').val(selectedClient.zip);
            $('#editClientCity').val(selectedClient.country);
            $('#editClientStreet').val(selectedClient.street);
            $('#editClientPhone').val(selectedClient.phonenumber);
            $('#editClientEmail').val(selectedClient.email);

            $('#editClientModal').modal('show');
        });
    });


</script>