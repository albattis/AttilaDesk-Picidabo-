<?php

use app\model\Szabadsagok;
use db\Database;


require_once __DIR__ . '/../../../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST["user_id"];
    $nap = $_POST["nap"];

    // Adatbázis kapcsolat
    $conn = Database::getConnection();

    // Szabadság mentése az adatbázisba
    $stmt = $conn->prepare("INSERT INTO szabadsagok (user_id, nap) VALUES (:user_id, :nap)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':nap', $nap);
    $stmt->execute();

    // Visszairányítás az űrlaphoz vagy egy siker oldalon
    header("Location: /picidabo/index.php?controller=user&action=index");
    exit();
}
?>

