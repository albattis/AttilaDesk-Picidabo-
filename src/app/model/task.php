<?php

namespace app\model;

use DateTime;
use db\Database;

use db\Database as Db;

use PDO;
class task
{
private $task_id;
private $task_name;
private $category_id;

private $task_description;

private $task_due_date;

private $task_status;

private $task_priority;
private $task_end_date;
private $user_id;
private $ugyfel_id;


    public static function findAll()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM task ORDER BY task_due_date DESC";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $tasks = [];
        foreach ($rows as $row)
        {
            $task = new self();
            $task->setTaskId($row['task_id']);
            $task->setTaskName($row['task_name']);
            $task->setCategoryId($row['task_category_id']);
            $task->setTaskDescription($row['task_description']);
            $task->setTaskDueDate($row['task_due_date']);
            $task->setTaskStatus($row['task_status']);
            $task->setTaskPriority($row['task_priority']);
            $task->setTaskEndDate($row['task_end_date']);
            $task->setUserId($row['user_id']);
            $task->setUgyfelId($row['ugyfel_id']);
            $tasks[] = $task;
        }

        return $tasks;

    }



    public static function Taskend($id)
    {
        try
        {
            $a = new DateTime();
            $enddate = $a->format("Y-m-d H:i:s");
            $conn = Db::getConnection();
            if ($conn)
            {
                $sql = "UPDATE `task` SET `task_end_date` = :taskend WHERE `task`.`task_id` = :id;";
                $statement = $conn->prepare($sql);
                $statement->execute([ ':taskend' => $enddate, ':id' => $id ]); if ($statement->rowCount() > 0) { echo "A feladat dátuma sikeresen frissítve lett!"; } else { echo "A feladat dátuma nem lett frissítve. Ellenőrizd, hogy a `task_id` létezik és helyes-e."; } return $statement->fetchObject(self::class); } else { echo "Adatbázis kapcsolat sikertelen!"; } } catch (PDOException $e) { echo "Hiba történt: " . $e->getMessage(); }
    self::Taskendstatus($id);
    }

    public static function Taskendstatus($id)
    {
        try
        {

            $conn = Db::getConnection();
            if ($conn)
            {
                $sql = "UPDATE `task` SET `task_status` = :taskend WHERE `task`.`task_id` = :id;";
                $statement = $conn->prepare($sql);
                $statement->execute([ ':taskend' => "befejezett", ':id' => $id ]); if ($statement->rowCount() > 0) { echo "A feladat dátuma sikeresen frissítve lett!"; } else { echo "A feladat dátuma nem lett frissítve. Ellenőrizd, hogy a `task_id` létezik és helyes-e."; } return $statement->fetchObject(self::class); } else { echo "Adatbázis kapcsolat sikertelen!"; } } catch (PDOException $e) { echo "Hiba történt: " . $e->getMessage(); }
    }
    public static function ReopenTask($taskId)
    {

        $end="0000-00-00 00:00:00";
        $db = Database::getConnection();
        $sql = "UPDATE task SET task_end_date = :end WHERE task_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
        $stmt->bindParam(':end', $end, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {
            echo "Feladat visszanyitva.";
        }
        else
        {
            echo "Nem sikerült visszanyitni a feladatot.";
        }
    }


public static function findByOneId($id)
{
    $conn = Database::getConnection();
    $sql = "SELECT * FROM task WHERE task_id = :id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(":id", $id);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $task = new self();
    $task->setTaskId($row['task_id']);
    $task->setTaskName($row['task_name']);
    $task->setCategoryId($row['task_category_id']);
    $task->setTaskDescription($row['task_description']);
    $task->setTaskDueDate($row['task_due_date']);
    $task->setTaskStatus($row['task_status']);
    $task->setTaskPriority($row['task_priority']);
    $task->setTaskEndDate($row['task_end_date']);
    $task->setUserId($row['user_id']);
    $task->setUgyfelId($row['ugyfel_id']);
    return $task;
}
    public static function taskUserCount($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT COUNT(task_id) FROM task WHERE user_id = :id";
        $statement = $conn->prepare($sql);
        $statement->execute([ ':id' => $id, ]);
        $count = $statement->fetchColumn();
        return $count;
    }

    public static function AktualTask()
    {
        $conn=Database::getConnection();
        $sql="SELECT COUNT(task_id) FROM task where task_end_date ='0000-00-00 00:00:00';";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $count = $statement->fetchColumn();
        return $count;
    }

    public static function updateStatus($taskId, $newStatus)
    {
        $conn=Database::getConnection();
        $sql = "UPDATE `task` SET `task_status` = :status WHERE `task`.`task_id` = :id";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':id' => $taskId,
            ':status' => $newStatus
        ]);

    }


    public function getProgressPercentage() {
        $status = $this->getTaskStatus();

        switch ($status) {
            case 'felvett':
                return 10;
            case 'nyomtatva':
                return 50;
            case 'befejezett':
                return 100;
            case 'ertesitve':
                return 75;
            default:
                return 0;
        }
    }

    public function save()
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO task (task_name, task_description, task_category_id, task_due_date,task_priority, task_end_date,user_id,ugyfel_id) VALUES (?, ?,?,?,?, ?,?, ?)");
        return $stmt->execute([$this->task_name, $this->task_description, $this->category_id, $this->task_due_date,$this->task_priority,$this->task_end_date, $this->user_id,$this->ugyfel_id]);
    }


/**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->task_id;
    }

    /**
     * @param mixed $task_id
     */
    public function setTaskId($task_id)
    {
        $this->task_id = $task_id;
    }

    /**
     * @return mixed
     */
    public function getTaskName()
    {
        return $this->task_name;
    }

    /**
     * @param mixed $task_name
     */
    public function setTaskName($task_name)
    {
        $this->task_name = $task_name;
    }

    /**
     * @return mixed
     */
    public function getTaskDescription()
    {
        return $this->task_description;
    }

    /**
     * @param mixed $task_description
     */
    public function setTaskDescription($task_description)
    {
        $this->task_description = $task_description;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getTaskDueDate()
    {
        return $this->task_due_date;
    }

    /**
     * @param mixed $task_due_date
     */
    public function setTaskDueDate($task_due_date)
    {
        $this->task_due_date = $task_due_date;
    }

    /**
     * @return mixed
     */
    public function getTaskStatus()
    {
        return $this->task_status;
    }

    /**
     * @param mixed $task_status
     */
    public function setTaskStatus($task_status)
    {
        $this->task_status = $task_status;
    }

    /**
     * @return mixed
     */
    public function getTaskPriority()
    {
        return $this->task_priority;
    }

    /**
     * @param mixed $task_priority
     */
    public function setTaskPriority($task_priority)
    {
        $this->task_priority = $task_priority;
    }

    /**
     * @return mixed
     */
    public function getTaskEndDate()
    {
        return $this->task_end_date;
    }

    /**
     * @param mixed $task_end_date
     */
    public function setTaskEndDate($task_end_date)
    {
        $this->task_end_date = $task_end_date;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getUgyfelId()
    {
        return $this->ugyfel_id;
    }

    /**
     * @param mixed $ugyfel_id
     */
    public function setUgyfelId($ugyfel_id)
    {
        $this->ugyfel_id = $ugyfel_id;
    }

}