<?php

namespace app\model;

use db\Database as Db;

class Track
{

    private $id;
    private $no;
    private $title;
    private $length;
    private $album_id;

    /**
     * @return Track[] Az összes track
     */
    public static function findAll()
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM `tracks`");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    /**
     * @param $id
     * @return Track Egy Track lekérése $id alapján.
     */
    public static function findOneById($id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM `track` WHERE id = :id");
        $statement->execute([
            ':id' => $id,
        ]);
        return $statement->fetchObject(self::class);
    }

    /**
     * @param $album_id
     * @return Track[] Adott albumhoz tartozó trackek lekérése.
     */
    public static function findAllByAlbumId($album_id)
    {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM `track` WHERE album_id = :album_id");
        $statement->execute([
            ':album_id' => $album_id,
        ]);
        return $statement->fetchAll(\PDO::FETCH_CLASS, self::class);
    }








    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNo()
    {
        return $this->no;
    }

    public function setNo($no)
    {
        $this->no = $no;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getAlbum_id()
    {
        return $this->album_id;
    }

    public function setAlbum_id($album_id)
    {
        $this->album_id = $album_id;
    }

    public function hasError($type="")
    {
        return false;
    }
}