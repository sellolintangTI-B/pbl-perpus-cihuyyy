<?php
namespace App\Core;
class Controller {
    static $layoutType = [
        "civitas" => "Civitas",
        "admin" => "Admin",
        "default" => "default",
    ];

    public function model($model) 
    {
        require_once('app/models/' . $model . '.php');
        $class = "app\\models\\" . $model;
        return new $class;
    }    

    public function view($view, $data = [], $layoutType = "default") 
    {   
        extract($data);
        ob_start();
        require_once('app/views/' . $view . '.php');
        $content = ob_get_clean();
        switch($layoutType) {
            case $this::$layoutType["admin"]:
                require('app/components/layout/Admin.php');
                break;
            case $this::$layoutType["civitas"]:
                require('app/components/layout/Civitas.php');
                break;
            default:
                require('app/components/layout/Default.php');
                break;
        }
    }
}
?>