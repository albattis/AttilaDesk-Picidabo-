<?php

namespace app\model;

use db\Database;
use PDO;

class Ugyfel
{
    private $id;
    private $firstname;
    private $lastname;
    private $zip;
    private $country;
    private $street;
    private $phonenumber;
    private $email;


    public function save()
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("INSERT INTO `ugyfel` (`firstname`, `lastname`, `zip`, `country`, `street`, `phonenumber`, `email`) VALUES (?,?,?,?,?,?,?);");
        return $stmt->execute([
            $this->firstname,
            $this->lastname,
            $this->zip,
            $this->country,
            $this->street,
            $this->phonenumber,
            $this->email
        ]);

    }

    public function modify()
    {

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE ugyfel SET firstname = :firstname, lastname = :lastname, zip = :zip, country = :city, street = :street, phonenumber = :phone, `email` = :email WHERE id = :id");
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
        $stmt->bindParam(':zip', $this->zip, PDO::PARAM_STR);
        $stmt->bindParam(':city', $this->country, PDO::PARAM_STR);
        $stmt->bindParam(':street', $this->street, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $this->phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        return $stmt->execute();

    }


    public static function findAll()
    {
        $conn = Database::getConnection();
        $stmt = $conn->query("SELECT * FROM ugyfel");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

 public static function findOneById($id)
 {

     $conn = Database::getConnection();
     $sql = "SELECT * FROM `ugyfel` WHERE `id` = :id";
     $statement = $conn->prepare($sql);
     $statement->execute([':id' => $id]);
     $row = $statement->fetch(PDO::FETCH_ASSOC);
     if ($row)
     {
         $user = new self();
         $user->id = $row['id'];
         $user->firstname = $row['firstname'];
         $user->lastname = $row['lastname'];
         $user->zip = $row['zip'];
         $user->country = $row['country'];
         $user->street = $row['street'];
         $user->phonenumber = $row['phonenumber'];
         $user->email = $row['email'];
         return $user;
     }
     return null;


 }

    public static function searchClients($query)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT id, firstname, lastname, zip, country, street FROM ugyfel WHERE firstname LIKE ? OR lastname LIKE ?");
        $stmt->execute(['%' . $query . '%', '%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allUgyfelCount()
    {
        $conn=Database::getConnection();
        $stmt=$conn->prepare('SELECT COUNT(id) from ugyfel;');
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * @param mixed $phonenumber
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


}