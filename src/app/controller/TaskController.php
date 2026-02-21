<?php

namespace app\controller;

use app\model\task;
use app\model\Ugyfel;

class TaskController extends MainController
{
    protected $controllerName = 'task';

    public function actionIndex()
    {
        // Modern approach: Use JOIN to avoid N+1 queries
        $tasks = Task::findAllWithUser();

        $this->title = 'Feladatok';

        return $this->render('index', [
            'tasks' => $tasks,

        ]);
    }

    public function actionView($id)
    {
        $this->title = $id. ' számú feladat';
        $task=Task::findByOneId($id);
        return $this->render('view', [

            'task' => $task
        ]);
    }

    public function actionInsert()
    {
        $ugyfelek=Ugyfel::findAll();
        $this->title = 'Feladatok';
        return $this->render("insert",[
            'ugyfelek' => $ugyfelek

        ]);
    }


}
