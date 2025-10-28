<?php

namespace App\Controllers;
use app\core\Controller;
use app\utils\Authentication;
class AdminController extends Controller {

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }

    public function index()
    {
        return $this->view('admin/rooms/index');
    }

    public function logout()
    {
        $logout = $this->authUser->logout();
        if($logout) {
            header('location:' . URL . '/auth/login');
        }
    }

}