<?php

namespace App\Controllers\Auth;

use App\Core\Controller;
use App\Utils\Authentication;

class PasswordController extends Controller
{
    // private $authUser;

    // public function __construct()
    // {
    //     $this->authUser = new Authentication;
    // }
    public function forget()
    {
        $this->view('auth/forget-password');
    }
    public function successfully_sent()
    {
        $this->view('auth/successfully-sent');
    }
    public function new()
    {
        $this->view('auth/new-password');
    }
}
