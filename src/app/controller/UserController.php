<?php
namespace app\controller;

use app\model\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use db\Database;
use Exception;

class UserController extends MainController
{
    protected $controllerName = 'user';

    public function actionIndex()
{
// Ellenőrizd, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['jwt'])) {
header("Location: index.php?controller=user&action=login");
exit;
}

try {
$secret_key = "your-256-bit-secret";
$jwt = $_SESSION['jwt'];
$decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));

// Védett tartalom megjelenítése
return $this->render('index', [
'username' => $decoded->username
]);
} catch (Exception $e) {
return "Hozzáférés megtagadva: " . $e->getMessage();
}
}

public function actionLogin()
{
// Adatot kaptunk POST formájában, be kell léptetni a usert
if (!empty($_POST['username']) && !empty($_POST['password'])) {
$user = User::findOneByUsername($_POST["username"]);

if ($user) {
$token = $user->doLogin($_POST['password']);
if ($token) {
// Token mentése a munkamenetbe
$_SESSION['jwt'] = $token;
$_SESSION['user_id'] = $user->getId();

// Sikeres bejelentkezés esetén átirányítás
header("Location: index.php?controller=user&action=index");
exit;
}
}

echo '<script>alert("Sikertelen bejelentkezés!");</script>';

}

// Bejelentkezési űrlap megjelenítése
$this->title = "Login";
return $this->render('login');
}

public function actionLogout()
{
$_SESSION['user_id'] = '';
unset($_SESSION['user_id']);
unset($_SESSION['jwt']); // Token törlése
header("Location: index.php");
}



    public function actionInsert()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit;
        }

        $decoded = $this->checkAuthentication();

        if ($decoded->role !== 'boss') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Access denied: You do not have permission to add new users.']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        error_log("Data received: " . print_r($data, true));

            if (json_last_error() !== JSON_ERROR_NONE)
            {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Invalid JSON input: ' . json_last_error_msg()]);
                exit;
            }

        if (!empty($data['username']) && !empty($data['password']) && !empty($data['role'])) {
            $user = new User();
            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setUsername($data['username']);
            $user->setPassword(hash('sha256', $data['password']));
            $user->setAssignment($data['role']);

            if ($user->save()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to add new user.']);
                exit;
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit;
    }




    private function checkAuthentication()
    {
        if (!isset($_SESSION['jwt'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Not authenticated.']);
            exit;
        }

        try {
            $secret_key = "your-256-bit-secret";
            $jwt = $_SESSION['jwt'];
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));

            if ($decoded->exp < time()) {
                $user = User::findOneById($decoded->user_id);
                $newToken = $user->generateToken();
                $_SESSION['jwt'] = $newToken;

                header("Location: index.php?controller=user&action=login");
                throw new Exception('Expired token. New token generated, please re-authenticate.');
                exit;
            }

            return $decoded; // Hitelesített felhasználó adatai és szerepköre
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Authentication failed: ' . $e->getMessage()]);
            exit;
        }
    }

}
