<?php

namespace App\Controllers\User;

use App\Core\Controller;
use App\Utils\Authentication;
use App\Utils\Validator;

class UserController extends Controller
{

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }

    public function index()
    {
        // $user = $_SESSION['loggedInUser'];
        return $this->view('user/beranda/index', layoutType: $this::$layoutType['civitas']);
    }

    public function logout()
    {
        $logout = $this->authUser->logout();
        if ($logout) {
            header('location:' . URL . '/auth/login');
        }
    }
}
