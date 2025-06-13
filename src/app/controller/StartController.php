<?php

namespace app\controller;
class StartController extends MainController
{

    protected $controllerName="Start";
    public function actionIndex()
    {


        $this->title = 'Kezdőoldal';

        return $this->render('index');
    }



}