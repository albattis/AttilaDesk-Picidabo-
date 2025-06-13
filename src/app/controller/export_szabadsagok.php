<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use app\model\Szabadsagok;

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=szabadsagok.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Felhasználó', 'Nap'));

$szabadsagok = Szabadsagok::findAll();

foreach ($szabadsagok as $szabadsag) {
    fputcsv($output, array($szabadsag['nickname'], $szabadsag['nap']));
}

fclose($output);
exit();
