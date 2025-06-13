<?php

namespace app\controller;

use app\model\AlapBeosztas;
use app\model\Szabadsagok;
use app\model\User;

class BeosztasController {

    public function getAktualisBeosztas() {
        // Napok leképezése
        $napok = [
            'Hétfő' => 'monday',
            'Kedd' => 'tuesday',
            'Szerda' => 'wednesday',
            'Csütörtök' => 'thursday',
            'Péntek' => 'friday',
            'Szombat' => 'saturday'
        ];

        // Lekérdezzük az alap beosztást
        $alapBeosztasok = AlapBeosztas::findAll();

        // Lekérdezzük a szabadságokat a megadott dátumtartományra (egy hétre)
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $endDate = date('Y-m-d', strtotime('sunday this week'));
        $szabadsagok = Szabadsagok::findAllByDateRange($startDate, $endDate);

        // Létrehozzuk az aktuális beosztást
        $aktualisBeosztas = [];
        foreach ($alapBeosztasok as $alapBeosztas) {
            $nap = date('Y-m-d', strtotime('this week ' . $napok[$alapBeosztas->getNap()]));

            $aktualisBeosztas[$nap] = [
                'fo_delelott' => $alapBeosztas->getFoDelelott(),
                'masod_delelott' => $alapBeosztas->getMasodDelelott(),
                'sajat_terulet_delelott' => $alapBeosztas->getSajatTeruletDelelott(),
                'fo_delutan' => $alapBeosztas->getFoDelutan(),
                'masod_delutan' => $alapBeosztas->getMasodDelutan(),
                'sajat_terulet_delutan' => $alapBeosztas->getSajatTeruletDelutan()
            ];
        }

        // Alkalmazzuk a szabadságokat és a helyettesítéseket az aktuális beosztásra
        foreach ($szabadsagok as $szabadsag) {
            $nap = $szabadsag->getNap();

            if (isset($aktualisBeosztas[$nap])) {
                // Délelőtt
                if ($aktualisBeosztas[$nap]['fo_delelott'] == $szabadsag->getUserId()) {
                    $aktualisBeosztas[$nap]['fo_delelott'] = $aktualisBeosztas[$nap]['masod_delelott'];
                    $aktualisBeosztas[$nap]['masod_delelott'] = $aktualisBeosztas[$nap]['sajat_terulet_delelott'];
                    $aktualisBeosztas[$nap]['sajat_terulet_delelott'] = null; // vagy új felhasználó ID-ja
                } elseif ($aktualisBeosztas[$nap]['masod_delelott'] == $szabadsag->getUserId()) {
                    $aktualisBeosztas[$nap]['masod_delelott'] = $aktualisBeosztas[$nap]['sajat_terulet_delelott'];
                    $aktualisBeosztas[$nap]['sajat_terulet_delelott'] = null; // vagy új felhasználó ID-ja
                } elseif ($aktualisBeosztas[$nap]['sajat_terulet_delelott'] == $szabadsag->getUserId()) {
                    $aktualisBeosztas[$nap]['sajat_terulet_delelott'] = null; // vagy új felhasználó ID-ja
                }

                // Délután
                if ($aktualisBeosztas[$nap]['fo_delutan'] == $szabadsag->getUserId()) {
                    $aktualisBeosztas[$nap]['fo_delutan'] = $aktualisBeosztas[$nap]['masod_delutan'];
                    $aktualisBeosztas[$nap]['masod_delutan'] = $aktualisBeosztas[$nap]['sajat_terulet_delutan'];
                    $aktualisBeosztas[$nap]['sajat_terulet_delutan'] = null; // vagy új felhasználó ID-ja
                } elseif ($aktualisBeosztas[$nap]['masod_delutan'] == $szabadsag->getUserId()) {
                    $aktualisBeosztas[$nap]['masod_delutan'] = $aktualisBeosztas[$nap]['sajat_terulet_delutan'];
                    $aktualisBeosztas[$nap]['sajat_terulet_delutan'] = null; // vagy új felhasználó ID-ja
                } elseif ($aktualisBeosztas[$nap]['sajat_terulet_delutan'] == $szabadsag->getUserId()) {
                    $aktualisBeosztas[$nap]['sajat_terulet_delutan'] = null; // vagy új felhasználó ID-ja
                }
            }
        }

        return $aktualisBeosztas;
    }

    public function renderAktualisBeosztas() {
        $aktualisBeosztas = $this->getAktualisBeosztas();

        // Átadjuk az adatokat a nézetnek (view)
        require 'view/beosztas/beosztas.php';
    }
}
