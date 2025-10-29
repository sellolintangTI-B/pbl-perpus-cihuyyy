<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Utils\Authentication;

class AdminController extends Controller {

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }

    public function index()
    {
        return $this->view('admin/rooms/index', layoutType: $this::$layoutType['admin']);
    }
    public function dashboard()
    {
        return $this->view('admin/dashboard/index', layoutType: $this::$layoutType['admin']);
    }
    

    public function logout()
    {
        $logout = $this->authUser->logout();
        if($logout) {
            header('location:' . URL . '/auth/login');
        }
    }

}