<?php

namespace app\model;

use db\Database;
use PDO;

class beosztas
{

    private $id;
    private $nap;
    private $fo;

    private $masod;
    private $harmad;



    public static function findAll()
    {
        $conn=Database::getConnection();
        $sql="SELECT * FROM beosztas";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $result;

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
    public function getNap()
    {
        return $this->nap;
    }

    /**
     * @param mixed $nap
     */
    public function setNap($nap)
    {
        $this->nap = $nap;
    }

    /**
     * @return mixed
     */
    public function getFo()
    {
        return $this->fo;
    }

    /**
     * @param mixed $fo
     */
    public function setFo($fo)
    {
        $this->fo = $fo;
    }

    /**
     * @return mixed
     */
    public function getMasod()
    {
        return $this->masod;
    }

    /**
     * @param mixed $masod
     */
    public function setMasod($masod)
    {
        $this->masod = $masod;
    }

    /**
     * @return mixed
     */
    public function getHarmad()
    {
        return $this->harmad;
    }

    /**
     * @param mixed $harmad
     */
    public function setHarmad($harmad)
    {
        $this->harmad = $harmad;
    }




}