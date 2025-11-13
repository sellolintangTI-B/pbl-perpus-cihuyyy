<?php 

namespace App\Controllers\Auth;

use App\Utils\Authentication;

class LogoutController {
    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }
    public function logout()
    {
        $logout = $this->authUser->logout();
        if($logout) {
            header('location:' . URL . '/auth/login/index');
        }
    }
}