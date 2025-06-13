<?php


namespace app\model;

use db\Database;
use PDO;

class User
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $assignment;

    /**
     * @var string
     */
    private $username;



    public static function validateToken($token)
    {

        $parts = explode('.', $token);
        if (count($parts) !== 3) {

            return false;

        }

        list($base64UrlHeader, $base64UrlPayload, $providedSignature) = $parts;
        $secret = 'your-256-bit-secret';
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        if ($base64UrlSignature === $providedSignature) {
            $payload = json_decode(base64_decode($base64UrlPayload), true);

            return $payload;
        }


        return false;
    }



    private static $currentUser = null;

    public static function findAll()
    {
        $conn= Database::getConnection();
        $sql="SELECT * FROM `user`";
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'app\\model\\User');

    }


    public function generateToken()
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'user_id' => $this->id,
            'username' => $this->username,
            'role' => $this->assignment,
            'exp' => time() + (60 * 120) // 3 óra lejárati idő
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $secret = "your-256-bit-secret";
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }


    public function save()
    {
        $conn = Database::getConnection();
        if ($this->id) {
            // Ha már létezik a felhasználó, frissítjük az adatokat
            $sql = "UPDATE user SET firstname = :firstname, lastname = :lastname, password = :password, assignment = :assignment, username = :username WHERE id = :id";
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                ':firstname' => $this->firstname,
                ':lastname' => $this->lastname,
                ':password' => $this->password,
                ':assignment' => $this->assignment,
                ':username' => $this->username,
                ':id' => $this->id
            ]);
        } else {
            // Új felhasználó hozzáadása
            $sql = "INSERT INTO user (firstname, lastname, password, assignment, nickname) VALUES (:firstname, :lastname, :password, :assignment, :nickname)";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                ':firstname' => $this->firstname,
                ':lastname' => $this->lastname,
                ':password' => $this->password,
                ':assignment' => $this->assignment,
                ':nickname' => $this->username
            ]);
            if ($result) {
                $this->id = $conn->lastInsertId();
            }
            return $result;
        }
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
    public function getAssignment()
    {
        return $this->assignment;
    }

    /**
     * @param mixed $assignment
     */
    public function setAssignment($assignment)
    {
        $this->assignment = $assignment;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public static function findOneById($id)
    { $conn = Database::getConnection();
        $sql = "SELECT * FROM user WHERE `id` = :id";
        $statement = $conn->prepare($sql);
        $statement->execute([ ":id" => $id ]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row)
        {
            $user = new self();
            $user->setId($row['id']);
            $user->setFirstname($row['firstname']);
            $user->setLastname($row['lastname']);
            $user->setPassword($row['password']);
            $user->setAssignment($row['assignment']);
            $user->setUsername($row['nickname']);
            return $user; }
        return null; }

    public static  function findOneByUsername($username)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM user WHERE `nickname` = :username";
        $statement = $conn->prepare($sql);
        $statement->execute([
            ":username" => $username
        ]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row)
        {
            $user = new self();
            $user->setId($row['id']);
            $user->setFirstname($row['firstname']);
            $user->setLastname($row['lastname']);
            $user->setPassword($row['password']);
            $user->setAssignment($row['assignment']);
            $user->setUsername($row['nickname']);
            return $user; }
        return null;
    }

    /**
     * @param $password
     * @return bool
     */
    public function doLogin($password)
    {
        if (hash('sha256', $password) == $this->password)
        {
            $_SESSION['user_id'] = $this->id;
            return $this->generateToken();
        }

        return false;
    }



    /**
     * @return User|array|false|null
     */

    public static function getUsers()
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, firstname, lastname FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public  static function getCurrentUser()
    {
        if(self::$currentUser == null && !empty($_SESSION['user_id']))
        {
            self::$currentUser = self::findOneById($_SESSION['user_id']);

        }
        return self::$currentUser;
    }

    public static function currentUserCan()
    {
        $user = self::getCurrentUser();

        if(is_null($user))
        {
            return false;
        }

        if($user->getAssignment() == 'employer')
        {
            return true;
        }

        return false;

    }

    public function findAllName()
    {
        $conn=Database::getConnection();
        $stmt = $conn->prepare("SELECT id, firstname, lastname FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function findOneNickname($id)
    {
        $conn = Database::getConnection();
        $stmt = $conn->prepare("SELECT nickname FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['nickname'];
        } else {
            return null; // Vagy egy alapértelmezett érték, pl. 'N/A'
        }
    }


}