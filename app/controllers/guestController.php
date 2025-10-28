<?php
namespace App\Controllers;
use app\core\Controller;
class guest extends Controller{
    public function index(){
        return $this->view('guest/index', layoutType: $this::$layoutType["default"]);
    }
}