<?php

use db\Database;

require_once __DIR__ . '/../../../vendor/autoload.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id = $_POST["id"];

// Adatbázis kapcsolat
$conn = Database::getConnection();

// Szabadság törlése az adatbázisból
$stmt = $conn->prepare("DELETE FROM szabadsagok WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

// Visszairányítás a szabadságok oldalra
header("Location: /picidabo/index.php?controller=szabadsag&action=index");
exit();
}
?>