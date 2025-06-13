<?php

use app\controller\BeosztasController;
use app\model\User;

$controller = new BeosztasController();
$aktualisBeosztas = $controller->getAktualisBeosztas();
?>
<div class="container-fluid">
<div class="row">
    <div class="col-12">
        <h1>Aktuális Heti Beosztás</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Nap</th>
                <th>Délelőtt Fő</th>
                <th>Délelőtt Másod</th>
                <th>Délelőtt Saját Terület</th>
                <th>Délután Fő</th>
                <th>Délután Másod</th>
                <th>Délután Saját Terület</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($aktualisBeosztas as $nap => $beosztas): ?>
                <tr>
                    <td><?php echo htmlspecialchars($nap); ?></td>
                    <td class="user-<?php echo htmlspecialchars($beosztas['fo_delelott']); ?>">
                        <?php echo (new app\model\User)->findOneNickname($beosztas['fo_delelott']); ?>
                    </td>
                    <td class="user-<?php echo htmlspecialchars($beosztas['masod_delelott']); ?>">
                        <?php echo (new app\model\User)->findOneNickname($beosztas['masod_delelott']); ?>
                    </td>
                    <td class="user-<?php echo htmlspecialchars($beosztas['sajat_terulet_delelott']); ?>">
                        <?php echo (new app\model\User)->findOneNickname($beosztas['sajat_terulet_delelott']); ?>
                    </td>
                    <td class="user-<?php echo htmlspecialchars($beosztas['fo_delutan']); ?>">
                        <?php echo (new app\model\User)->findOneNickname($beosztas['fo_delutan']); ?>
                    </td>
                    <td class="user-<?php echo htmlspecialchars($beosztas['masod_delutan']); ?>">
                        <?php echo (new app\model\User)->findOneNickname($beosztas['masod_delutan']); ?>
                    </td>
                    <td class="user-<?php echo htmlspecialchars($beosztas['sajat_terulet_delutan']); ?>">
                        <?php echo (new app\model\User)->findOneNickname($beosztas['sajat_terulet_delutan']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>


