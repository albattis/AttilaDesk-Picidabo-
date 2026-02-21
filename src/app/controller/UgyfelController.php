<?php


namespace app\controller;


use app\model\Ugyfel;

class UgyfelController extends MainController
{
    protected $controllerName = 'ugyfel';

    public function actionInsert()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // CSRF validation
            if (!\helper\Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                return "CSRF token validation failed.";
            }

            $ugyfel = new Ugyfel();
            $ugyfel->setFirstname($_POST["firstname"] ?? '');
            $ugyfel->setLastname($_POST["lastname"] ?? '');
            $ugyfel->setZip($_POST["zip"] ?? '');
            $ugyfel->setCountry($_POST["country"] ?? '');
            $ugyfel->setStreet($_POST["street"] ?? '');
            $ugyfel->setPhonenumber($_POST["phone"] ?? '');
            $ugyfel->setEmail($_POST["email"] ?? '');

            if ($ugyfel->save()) {
                header("Location: index.php?controller=User&action=index");
                exit;
            } else {
                return $this->render('insert', ['error' => 'Az ügyfél nem került be az adatbázisba']);
            }
        }

        return $this->render('insert');
    }

    public function actionIndex()
    {
        $ugyfel=Ugyfel::findAll();
        return $this->render('index',[
            'ugyfel'=>$ugyfel,
        ]);
    }
}