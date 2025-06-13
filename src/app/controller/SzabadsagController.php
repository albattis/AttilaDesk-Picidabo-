<?php

namespace app\controller;

class SzabadsagController extends MainController
{
    protected $controllerName = 'szabadsag';

    public function actionIndex()
    {


        $this->title = 'Feladatok';

        return $this->render('index');
    }


}