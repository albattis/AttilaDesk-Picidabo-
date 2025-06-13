<?php


namespace app\controller;


class MainController
{

    protected $controllerName = '';
    protected $title = '';
    protected $js = [];

    protected function render($view,$data = [])
    {
        extract($data);
        ob_start();
        include("src/app/view/{$this->controllerName}/{$view}.php");
        return ob_get_clean();
    }

    public function getJsFiles()
    {
        return $this->js;
    }
}