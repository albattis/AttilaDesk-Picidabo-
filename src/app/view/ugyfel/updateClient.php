<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../db/Database.php';
require_once __DIR__ . '/../../model/Ugyfel.php';

use app\model\Ugyfel;

// Naplózási pontok hozzáadása
error_log("updateClient.php script started");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
error_log("POST request received");

$clientId = $_POST['clientId'];
$clientName = $_POST['clientName'];
$clientZip = $_POST['clientZip'];
$clientCity = $_POST['clientCity'];
$clientStreet = $_POST['clientStreet'];
$clientPhone = $_POST['clientPhone'];
$clientEmail = $_POST['clientEmail'];

error_log("Client data: $clientId, $clientName, $clientZip, $clientCity, $clientStreet, $clientPhone, $clientEmail");

$ugyfel = Ugyfel::findOneById($clientId);
if ($ugyfel) {
list($firstname, $lastname) = explode(' ', $clientName, 2);
$ugyfel->setFirstname($firstname);
$ugyfel->setLastname($lastname);
$ugyfel->setZip($clientZip);
$ugyfel->setCountry($clientCity);
$ugyfel->setStreet($clientStreet);
$ugyfel->setPhonenumber($clientPhone);
$ugyfel->setEmail($clientEmail);

if ($ugyfel->modify()) {
error_log("Client data updated successfully");
    echo json_encode(['success' => true]);

} else {
error_log("Failed to update client data");
echo json_encode(['success' => false, 'message' => 'Adatok frissítése sikertelen.']);
}
} else {
error_log("Client not found");
echo json_encode(['success' => false, 'message' => 'Ügyfél nem található.']);
}
}
?>
