<?php

namespace App\Controllers\User;

use App\Core\Controller;
use App\Utils\Authentication;

class UserController extends Controller
{
    private $authUser;
    public function __construct()
    {
        $this->authUser = new Authentication;
    }
    public function profile()
    {
        $data = $this->authUser->user;
        $this->view('user/profile/index', $data, layoutType: $this::$layoutType['civitas']);
    }
}
