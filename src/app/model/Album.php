<?php


namespace app\model;

use db\Database;
use PDO;

class Album
{
    private $id;
    private $artist_id;
    private $title;
    private $released;
    private $genre;
    private $tcc;
    private $sales;
    private $image;
    private $enabled;

    private $loadableFields = [
        'artist_id',
        'title',
        'released',
        'genre',
        'tcc',
        'sales',
        'image',
    ];

    private $errors = [];



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
    public function getArtistId()
    {
        return $this->artist_id;
    }

    /**
     * @param mixed $artist_id
     */
    public function setArtistId($artist_id)
    {
        $this->artist_id = $artist_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * @param mixed $released
     */
    public function setReleased($released)
    {
        $this->released = $released;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getTcc()
    {
        return $this->tcc;
    }

    /**
     * @param mixed $tcc
     */
    public function setTcc($tcc)
    {
        $this->tcc = $tcc;
    }

    /**
     * @return mixed
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param mixed $sales
     */
    public function setSales($sales)
    {
        $this->sales = $sales;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public static  function findAll()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM album order by title";
        $statement = $conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * @param $id
     * @return Album
     */
    public static function findOneById($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM album WHERE id = :id";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ':id' => $id,
        ]);
        return $statement->fetchObject(self::class);
    }

    /**
     * @return string
     */
    public function getKep()
    {
        $path = "img/{$this->image}";
        if($this->image == null || $this->image == "" || !file_exists($path))
        {
            $path = "img/unknown.jpg";
        }
        return $path;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return Artist::findOneById($this->artist_id);
    }

    public function getTracks()
    {
        return Track::findAllByAlbumId($this->getId());
    }

    public function load($data)
    {
//        $this->title = $data['title'];
//        $this->artist_id = $data['artist_id'];
//        //....

        foreach ($this->loadableFields as $item) {
            if ('' != $data[$item]) {
                $this->$item = $data[$item];

            }
        }
    }

    public function validate()
    {
        if(!(is_numeric($this->artist_id) && $this->artist_id >0))
        {
            $this->errors['artist_id'] = 'Az előadó azonosítója szém kell, hogy legyen.';
        }

        return !(count($this->errors) > 0);
    }

    public function insert()
    {
        if($this->validate())
        {
            $db = Database::getConnection();

            $sql = "INSERT INTO `album` (`artist_id`, `title`, `released`, `genre`, `tcc`, `sales`, `image`)
                    VALUES 
                    ( :artist_id, :title, :released, :genre, :tcc, :sales, :image);";

            $statement = $db->prepare($sql);

            $result = $statement->execute([
                ':artist_id' => $this->artist_id,
                ':title' => $this->title,
                ':released' => $this->released,
                ':genre' => $this->genre,
                ':tcc' => $this->tcc,
                ':sales' => $this->sales,
                ':image' => $this->image,
            ]);

            if(false == $result)
            {
                $this->errors ['saveError'] = 'Sikertelen mentés';
                return false;
            }

            $this->id = $db->lastInsertId();

            return true;
        }
    }

    public function update()
    {
        if($this->validate())
        {
            $db = Database::getConnection();

            $sql = "UPDATE `album`
                        SET

                          `artist_id` = :artist_id,
                          `title` = :title,
                          `released` = :released,
                          `genre` = :genre,
                          `tcc` = :tcc,
                          `sales` = :sales,
                          `image` = :image
                          
                          where `id` = :id
                          ;";

            $statement = $db->prepare($sql);

            $result = $statement->execute([
                ':id' => $this->id,
                ':artist_id' => $this->artist_id,
                ':title' => $this->title,
                ':released' => $this->released,
                ':genre' => $this->genre,
                ':tcc' => $this->tcc,
                ':sales' => $this->sales,
                ':image' => $this->image,
            ]);

            if(false == $result)
            {
                $this->errors ['saveError'] = 'Sikertelen mentés';
                return false;
            }

            return true;
        }
    }

    public function delete()
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM `album` WHERE id = :id;";
        $statement = $db->prepare($sql);

        return $statement->execute([
            ':id' => $this->id,
        ]);
    }


}