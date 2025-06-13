<?php


namespace app\controller;


use app\model\Ugyfel;

class UgyfelController extends MainController
{
    protected $controllerName = 'ugyfel';

    public function actionInsert()
    {


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