<?php

class Admin extends Controller {

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
        if(empty($this->authUser->user)) {
            header('location:' . URL . '/auth/login');
        } elseif($this->authUser->user['role'] !== 'Admin') {
            header('location:' . URL . '/user/index');
        }
    }

    public function index()
    {
        echo "<h1> Hello " . $this->authUser->user['username'] . "</h1>";
    }

    public function logout()
    {
        $this->authUser->logout();
        echo "Logout" . $this->authUser->user['username'] . "</h1>";
    }
}