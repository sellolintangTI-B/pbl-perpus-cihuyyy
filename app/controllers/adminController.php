<?php

class Admin extends Controller {

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
    }

    public function index()
    {
        echo "<h1> Hello " . $this->authUser->user['username'] . "</h1>";
    }

    public function logout()
    {
        $logout = $this->authUser->logout();
        if($logout) {
            header('location:' . URL . '/auth/login');
        }
    }

}