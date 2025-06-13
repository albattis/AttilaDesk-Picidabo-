<?php

namespace app\model;

use db\Database;

use PDO;

class Artist
{

    protected static $table = 'artist';

    private $id;
    private $name;
    private $image;

    private $loadableFields = [
        'name',
        'image',
    ];

    public static  function findAll()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM artist";
        $statement = $conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * @param $id
     * @return Artist
     */
    public static function findOneById($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM artist WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':id' => $id,
        ]);
        return $statement->fetchObject(self::class);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function load($data)
    {

        foreach ($this->loadableFields as $item) {
            if ('' != $data[$item]) {
                $this->$item = $data[$item];

            }
        }
    }

    public function insert()
    {
        if(true)
        {
            $db = Database::getConnection();

            $sql = "INSERT INTO `artist` (`name`, `image`)
                    VALUES 
                    ( :name, :image);";

            $statement = $db->prepare($sql);

            $result = $statement->execute([
                ':name' => $this->name,
                ':image' => $this->image,
            ]);

            // $statement->debugDumpParams();

            if(false == $result)
            {
                $this->errors ['saveError'] = 'Sikertelen mentés';
                return false;
            }

            $this->id = $db->lastInsertId();

            return true;
        }
    }
}