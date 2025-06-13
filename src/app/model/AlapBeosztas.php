<?php

namespace app\model;



use db\Database;

class AlapBeosztas {
    private $id;
    private $nap;
    private $fo_delelott;
    private $masod_delelott;
    private $sajat_terulet_delelott;
    private $fo_delutan;
    private $masod_delutan;
    private $sajat_terulet_delutan;

    public function getId() {
        return $this->id;
    }

    public function getNap() {
        return $this->nap;
    }

    public function getFoDelelott() {
        return $this->fo_delelott;
    }

    public function getMasodDelelott() {
        return $this->masod_delelott;
    }

    public function getSajatTeruletDelelott() {
        return $this->sajat_terulet_delelott;
    }

    public function getFoDelutan() {
        return $this->fo_delutan;
    }

    public function getMasodDelutan() {
        return $this->masod_delutan;
    }

    public function getSajatTeruletDelutan() {
        return $this->sajat_terulet_delutan;
    }

    public static function findAll() {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM alap_beosztas");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'app\\model\\AlapBeosztas');
    }
}
