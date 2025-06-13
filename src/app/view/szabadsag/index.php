<?php

use app\model\Szabadsagok;


$currentDate = date('Y-m-d');
$filterUser = isset($_GET['filter-user']) ? $_GET['filter-user'] : null;
$szabadsagok = Szabadsagok::findAllFilteredByUser($filterUser);
?>
 <style>
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;

        }
        table {
            width: 400px; /* Fix táblázat szélesség */
            background-color: #1976d2; /* Intenzívebb kék háttérszín */
            color: #ffffff; /* Fehér szövegszín */
            border-radius: 10px; /* Lekerekített sarkok */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Árnyék */
        }
        thead {
            background-color: #0d47a1; /* Sötétebb kék a fejlécnek */
            color: #ffffff; /* Fehér szöveg a fejlécben */
        }
        tbody tr:hover {
            background-color: #1565c0; /* Kiemeléskor világosabb kék */
        }

    </style>

<div class="container-fluid table-container">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <h1 class="mt-5 text-center">Szabadságok</h1>
            <!-- Szűrés Űrlap -->
            <form action="index.php?controller=szabadsag&action=index" method="get" class="mb-3">
                <div class="form-group">
                    <label for="filter-user">Szűrés felhasználó szerint:</label>
                    <input type="text" id="filter-user" name="filter-user" class="form-control" placeholder="Felhasználónév">
                </div>
                <button type="submit" class="btn btn-primary">Szűrés</button>
            </form>
            <form action="src/app/controller/export_szabadsagok.php" method="get">
                <button type="submit" class="btn btn-gradient-glow mb-3">Exportálás CSV-be</button>
            </form>
            <table class="table table-striped text-center" style="width:500px;">
                <thead>
                <tr>
                    <th>Felhasználó</th>
                    <th>Nap</th>
                    <th>Művelet</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($szabadsagok as $szabadsag): ?>
                    <tr>
                        <td style="font-size: 20px"><?php echo htmlspecialchars($szabadsag['firstname']." ".$szabadsag['lastname']); ?></td>
                        <td style="font-size: 20px"><?php echo htmlspecialchars($szabadsag['nap']); ?></td>
                        <td>
                            <?php if ($szabadsag['nap'] >= $currentDate): ?>
                                <form action="src/app/controller/delete_szabadsag.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($szabadsag['id']); ?>">
                                    <button type="submit" class="btn btn-gradient-glow">Törlés</button>
                                </form>
                            <?php else: ?>
                                <button type="button" class="btn btn-secondary" disabled>Lejárt</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


