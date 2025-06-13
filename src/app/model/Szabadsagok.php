<?php

namespace app\model;



use db\Database;
use PDO;

class Szabadsagok {
    private $id;
    private $user_id;
    private $nap;

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getNap() {
        return $this->nap;
    }

    public static function findAll() {
        $conn = Database::getConnection();
        $sql = "SELECT szabadsagok.*, user.nickname , user.firstname,user.lastname 
                FROM szabadsagok 
                JOIN user ON szabadsagok.user_id = user.id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findAllFilteredByUser($filterUser = null) {
        $conn = Database::getConnection();
        if ($filterUser) {
            $sql = "SELECT szabadsagok.*, user.firstname, user.lastname 
                    FROM szabadsagok 
                    JOIN user ON szabadsagok.user_id = user.id
                    WHERE user.firstname LIKE :filterUser OR user.lastname LIKE :filterUser";
            $stmt = $conn->prepare($sql);
            $filterUser = '%' . $filterUser . '%';
            $stmt->bindParam(':filterUser', $filterUser);
        } else {
            $sql = "SELECT szabadsagok.*, user.firstname, user.lastname 
                    FROM szabadsagok 
                    JOIN user ON szabadsagok.user_id = user.id";
            $stmt = $conn->prepare($sql);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function findAllByDateRange($startDate, $endDate) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT * FROM szabadsagok WHERE nap BETWEEN :startDate AND :endDate");
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'app\\model\\Szabadsagok');
    }

    public static function isUserOnLeave($userId, $date) {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM szabadsagok WHERE user_id = :userId AND nap = :date");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
