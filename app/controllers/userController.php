<?php

class User extends Controller {

    private $authUser;

    public function __construct()
    {
        $this->authUser = new Authentication;
        if(empty($this->authUser->user)) {
            header('location:' . URL . '/auth/login');
        } elseif(!in_array($this->authUser->user['role'], ['Mahasiswa', 'Dosen'])) {
            header('location:' . URL . '/admin/index');
        }
    }

    public function index()
    {
        $user = $_SESSION['loggedInUser'];
        echo "<h1> Hello " . $user['username'] . "</h1>";
    }
}