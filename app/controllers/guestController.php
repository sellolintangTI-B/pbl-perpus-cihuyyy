<?php
namespace App\Controllers;
use App\Core\Controller;
class GuestController extends Controller{
    public function index(){
        return $this->view('guest/index', layoutType: $this::$layoutType["default"]);
    }
}